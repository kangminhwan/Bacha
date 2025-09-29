<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// 카테고리 매핑
$categoryMap = [
    'housemade-pastries' => 'Housemade Pastries',
    'sandwich' => 'Sandwich',
    'ice-desserts' => 'Ice Desserts',
    'farm-fresh-eggs' => 'Farm Fresh Eggs',
    'main' => 'Main',
    'croissants-and-cakes' => 'Croissants and Cakes',
    'salad' => 'Salad',
    'signature-dessert' => 'Our Signature Dessert'
];

// 메뉴 이름 생성 규칙
$menuNameRules = [
    'housemade-pastries' => [
        'madeleine' => '마들렌',
        'scone' => '스콘',
        'muffin' => '머핀',
        'cookie' => '쿠키',
        'pastry' => '페이스트리'
    ],
    'sandwich' => [
        'club' => '클럽 샌드위치',
        'blt' => 'BLT 샌드위치',
        'croque' => '크로크 무슈',
        'panini' => '파니니',
        'bagel' => '베이글 샌드위치'
    ],
    'ice-desserts' => [
        'gelato' => '젤라토',
        'ice-cream' => '아이스크림',
        'shaved-ice' => '빙수',
        'sorbet' => '소르베',
        'frozen' => '프로즌 디저트'
    ],
    'farm-fresh-eggs' => [
        'benedict' => '에그 베네딕트',
        'omelet' => '오믈렛',
        'scrambled' => '스크램블 에그',
        'french-toast' => '프렌치 토스트',
        'quiche' => '키시',
        'egg-fry' => '에그 프라이',
        'beef-confit' => '비프 콩피'
    ],
    'main' => [
        'pasta' => '파스타',
        'risotto' => '리조또',
        'steak' => '스테이크',
        'chicken' => '치킨',
        'fish' => '피쉬',
        'beef-confit' => '비프 콩피',
        'eggs' => '달걀 요리'
    ],
    'croissants-and-cakes' => [
        'croissant' => '크루아상',
        'cake' => '케이크',
        'tart' => '타르트',
        'cheesecake' => '치즈케이크'
    ],
    'salad' => [
        'caesar' => '시저 샐러드',
        'green' => '그린 샐러드',
        'quinoa' => '퀴노아 샐러드',
        'chicken' => '치킨 샐러드'
    ],
    'signature-dessert' => [
        'tiramisu' => '시그니처 티라미수',
        'chocolate' => '시그니처 초콜릿',
        'brownie' => '시그니처 브라우니',
        'pudding' => '시그니처 푸딩'
    ]
];

// 가격 범위
$priceRanges = [
    'housemade-pastries' => [3000, 6000],
    'sandwich' => [8000, 15000],
    'ice-desserts' => [5000, 12000],
    'farm-fresh-eggs' => [9000, 16000],
    'main' => [12000, 25000],
    'croissants-and-cakes' => [4000, 18000],
    'salad' => [7000, 14000],
    'signature-dessert' => [8000, 20000]
];

// 추가 설명 번역
$extraTranslations = [
    'chocolate' => '초콜릿',
    'vanilla' => '바닐라',
    'strawberry' => '딸기',
    'orange' => '오렌지',
    'lemon' => '레몬',
    'butter' => '버터',
    'plain' => '플레인',
    'cheese' => '치즈',
    'ham' => '햄',
    'chicken' => '치킨',
    'mushroom' => '버섯',
    'spinach' => '시금치',
    'blueberry' => '블루베리',
    'mango' => '망고',
    'apple' => '사과'
];

// 설명 템플릿
$descriptionTemplates = [
    'housemade-pastries' => ['부드럽고 촉촉한 수제', '신선한 재료로 만든', '전통 방식으로 구운'],
    'sandwich' => ['신선한 재료로 만든', '볼륨 가득한', '건강한'],
    'ice-desserts' => ['시원하고 달콤한', '프리미엄', '여름철 인기'],
    'farm-fresh-eggs' => ['농장 직송 신선 달걀로 만든', '푸짐한', '영양 가득한'],
    'main' => ['셰프 특제', '푸짐한 한 끼', '정성스럽게 조리한'],
    'croissants-and-cakes' => ['바삭하고 고소한', '달콤한', '프랑스 전통'],
    'salad' => ['신선한 야채로 만든', '건강한', '다이어트에 좋은'],
    'signature-dessert' => ['바샤커피만의 특별한', '시그니처', '정성스럽게 만든']
];

function translateExtra($extra) {
    global $extraTranslations;
    $words = explode(' ', $extra);
    $translated = [];
    foreach ($words as $word) {
        $translated[] = isset($extraTranslations[$word]) ? $extraTranslations[$word] : $word;
    }
    return implode(' ', $translated);
}

function generateMenuName($category, $filename) {
    global $menuNameRules, $categoryMap;
    
    $rules = isset($menuNameRules[$category]) ? $menuNameRules[$category] : [];
    $baseName = strtolower(preg_replace('/\.(jpg|jpeg|png|webp)$/i', '', $filename));
    
    // 규칙에서 매칭되는 키워드 찾기
    foreach ($rules as $keyword => $koreanName) {
        if (strpos($baseName, $keyword) !== false) {
            // 추가 설명 부분 처리
            $extra = trim(str_replace($keyword, '', $baseName));
            $extra = preg_replace('/[-_]/', ' ', $extra);
            if (!empty($extra)) {
                $extraKorean = translateExtra($extra);
                return $koreanName . ' ' . $extraKorean;
            }
            return $koreanName;
        }
    }
    
    // 매칭되지 않으면 기본 이름 생성
    $cleanName = ucwords(str_replace(['_', '-'], ' ', $baseName));
    return $categoryMap[$category] . ' ' . $cleanName;
}

function generatePrice($category) {
    global $priceRanges;
    
    $range = isset($priceRanges[$category]) ? $priceRanges[$category] : [5000, 15000];
    $price = rand($range[0], $range[1]);
    return round($price / 100) * 100; // 100원 단위로 반올림
}

function generateDescription($category, $name) {
    global $descriptionTemplates;
    
    $templates = isset($descriptionTemplates[$category]) ? $descriptionTemplates[$category] : ['맛있는'];
    $randomDesc = $templates[array_rand($templates)];
    $lastWord = array_pop(explode(' ', $name));
    return $randomDesc . ' ' . $lastWord . '입니다.';
}

function scanImageFolders() {
    global $categoryMap;
    
    $menuData = [];
    $id = 1;
    $imagesPath = '../images';
    
    if (!is_dir($imagesPath)) {
        return ['error' => 'images 폴더가 존재하지 않습니다.'];
    }
    
    foreach ($categoryMap as $folderName => $categoryName) {
        $categoryPath = $imagesPath . '/' . $folderName;
        
        if (!is_dir($categoryPath)) {
            continue;
        }
        
        $files = scandir($categoryPath);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === '이미지설명.txt') {
                continue;
            }
            
            $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $menuName = generateMenuName($folderName, $file);
                $menuItem = [
                    'id' => $id++,
                    'category' => $categoryName,
                    'name' => $menuName,
                    'desc' => generateDescription($folderName, $menuName),
                    'price' => generatePrice($folderName),
                    'image' => './images/' . $folderName . '/' . $file,
                    'filename' => $file,
                    'folder' => $folderName,
                    'tags' => [$categoryName]
                ];
                $menuData[] = $menuItem;
            }
        }
    }
    
    return $menuData;
}

try {
    $result = scanImageFolders();
    
    if (isset($result['error'])) {
        http_response_code(500);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'success' => true,
            'data' => $result,
            'count' => count($result),
            'timestamp' => date('Y-m-d H:i:s')
        ], JSON_UNESCAPED_UNICODE);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => '서버 오류가 발생했습니다: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>