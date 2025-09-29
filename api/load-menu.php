<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

/**
 * TXT 파일 기반 메뉴 로더
 * 형식: 카테고리|이름|설명|가격|이미지파일명|태그(옵션)
 */

function loadMenuFromTxt() {
    $menuFile = '../menu.txt';
    
    if (!file_exists($menuFile)) {
        return ['error' => 'menu.txt 파일이 존재하지 않습니다.'];
    }
    
    $lines = file($menuFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $menuData = [];
    $id = 1;
    
    foreach ($lines as $lineNumber => $line) {
        $line = trim($line);
        
        // 주석이나 빈 줄 건너뛰기
        if (empty($line) || $line[0] === '#') {
            continue;
        }
        
        // 파이프(|)로 분할
        $parts = explode('|', $line);
        
        // 최소 5개 필드 필요 (카테고리, 이름, 설명, 가격, 이미지)
        if (count($parts) < 5) {
            continue;
        }
        
        $category = trim($parts[0]);
        $name = trim($parts[1]);
        $description = trim($parts[2]);
        $price = intval(trim($parts[3]));
        $imagePath = trim($parts[4]);
        $tags = isset($parts[5]) ? array_map('trim', explode(',', $parts[5])) : [];
        
        // 데이터 검증
        if (empty($category) || empty($name) || empty($imagePath)) {
            continue;
        }
        
        // 이미지 파일 존재 확인
        $fullImagePath = '../images/' . $imagePath;
        if (!file_exists($fullImagePath)) {
            // 이미지가 없어도 메뉴는 표시하되 기본 이미지 사용
            $imagePath = 'default/no-image.jpg';
        }
        
        $menuItem = [
            'id' => $id++,
            'category' => $category,
            'name' => $name,
            'desc' => $description,
            'price' => $price,
            'image' => './images/' . $imagePath,
            'tags' => $tags,
            'source' => 'txt_file',
            'line_number' => $lineNumber + 1
        ];
        
        $menuData[] = $menuItem;
    }
    
    return $menuData;
}

function validateImageFiles($menuData) {
    $missingImages = [];
    
    foreach ($menuData as $item) {
        $imagePath = str_replace('./images/', '../images/', $item['image']);
        if (!file_exists($imagePath)) {
            $missingImages[] = [
                'menu' => $item['name'],
                'image' => $item['image'],
                'line' => $item['line_number']
            ];
        }
    }
    
    return $missingImages;
}

function getMenuStats($menuData) {
    $stats = [
        'total_items' => count($menuData),
        'categories' => [],
        'price_range' => [
            'min' => 0,
            'max' => 0,
            'avg' => 0
        ]
    ];
    
    $categoryCount = [];
    $prices = [];
    
    foreach ($menuData as $item) {
        // 카테고리별 개수
        if (!isset($categoryCount[$item['category']])) {
            $categoryCount[$item['category']] = 0;
        }
        $categoryCount[$item['category']]++;
        
        // 가격 통계
        $prices[] = $item['price'];
    }
    
    $stats['categories'] = $categoryCount;
    
    if (!empty($prices)) {
        $stats['price_range']['min'] = min($prices);
        $stats['price_range']['max'] = max($prices);
        $stats['price_range']['avg'] = round(array_sum($prices) / count($prices));
    }
    
    return $stats;
}

try {
    $menuData = loadMenuFromTxt();
    
    if (isset($menuData['error'])) {
        http_response_code(404);
        echo json_encode($menuData, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $missingImages = validateImageFiles($menuData);
    $stats = getMenuStats($menuData);
    
    $response = [
        'success' => true,
        'data' => $menuData,
        'stats' => $stats,
        'timestamp' => date('Y-m-d H:i:s'),
        'source' => 'menu.txt'
    ];
    
    // 누락된 이미지가 있으면 경고 포함
    if (!empty($missingImages)) {
        $response['warnings'] = [
            'missing_images' => $missingImages,
            'message' => '일부 이미지 파일이 존재하지 않습니다.'
        ];
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => '서버 오류가 발생했습니다: ' . $e->getMessage(),
        'file' => 'load-menu.php'
    ], JSON_UNESCAPED_UNICODE);
}
?>