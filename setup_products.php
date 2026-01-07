<?php
include 'dp.php';

$products = [
    [
        'name' => 'iPhone 14 Pro Max',
        'description' => 'Latest Apple flagship, Retina display, 48MP camera, A16 Bionic chip.',
        'price' => 1099.00,
        'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'MacBook Pro M2',
        'description' => 'Powerful laptop with M2 chip, all-day battery life, Liquid Retina XDR.',
        'price' => 1499.00,
        'image' => 'https://images.unsplash.com/photo-1517336714731-489679bd1bab?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'Sony WH-1000XM5',
        'description' => 'Noise canceling headphones, crystal clear sound, comfortable design.',
        'price' => 349.00,
        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'Apple Watch Series 8',
        'description' => 'Advanced smartwatch for fitness tracking, blood oxygen app, water resistant.',
        'price' => 399.00,
        'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'Canon EOS R5',
        'description' => 'Professional mirrorless camera for 8K video and photography.',
        'price' => 3899.00,
        'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'PlayStation 5 Controller',
        'description' => 'DualSense wireless controller, haptic feedback, built-in microphone.',
        'price' => 69.00,
        'image' => 'https://images.unsplash.com/photo-1606318801954-d46d46d3360a?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'Gaming Setup PC',
        'description' => 'High-end gaming PC, RTX 4090, RGB lighting, liquid cooling.',
        'price' => 2499.00,
        'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'name' => 'iPad Air 5',
        'description' => 'Lightweight and powerful tablet, M1 chip, supports Apple Pencil 2.',
        'price' => 599.00,
        'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=800&q=80'
    ]
];

$conn->query("DELETE FROM products");
$conn->query("ALTER TABLE products AUTO_INCREMENT = 1");

$stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");

foreach ($products as $product) {
    $stmt->bind_param("ssds", $product['name'], $product['description'], $product['price'], $product['image']);
    $stmt->execute();
}

echo "Database setup completed successfully.";
?>
