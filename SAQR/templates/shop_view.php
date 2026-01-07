<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alhjeen Store | متجر الهجين</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --hover-color: #2980b9;
        }
        body { font-family: 'Tajawal', sans-serif; background-color: #f4f7f6; }
        
        .navbar { background-color: var(--primary-color); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
            text-align: center;
        }
        .hero-title { font-weight: 800; margin-bottom: 15px; }
        .hero-text { font-size: 1.1rem; opacity: 0.9; }

        .filter-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            position: sticky;
            top: 20px;
        }
        .filter-title { font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px; }

        .card-product {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }
        .card-product:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .product-img-container {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 20px;
            border-bottom: 1px solid #f8f9fa;
        }
        .product-img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }
        .card-product:hover .product-img { transform: scale(1.05); }
        .card-body { padding: 20px; display: flex; flex-direction: column; }
        .product-title { font-weight: 700; font-size: 1.1rem; color: #333; margin-bottom: 10px; }
        .product-desc { color: #777; font-size: 0.9rem; flex-grow: 1; margin-bottom: 15px; }
        .product-price { color: var(--accent-color); font-weight: 800; font-size: 1.3rem; }
        
        .btn-add-cart {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            padding: 10px;
            transition: 0.3s;
            width: 100%;
        }
        .btn-add-cart:hover {
            background-color: var(--hover-color);
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="shop.php">
            <i class="fas fa-microchip me-2"></i> Alhjeen Store
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="shop.php">Home</a></li>
                <li class="nav-item position-relative mx-2">
                    <a class="nav-link btn btn-outline-light border-0" href="cart.php">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <?php if(isset($cart_count) && $cart_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                <?= $cart_count ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars($user_name) ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="orders.php"><i class="fas fa-box me-2"></i> My Orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <h1 class="hero-title display-4">Alhjeen - Tech World</h1>
        <p class="hero-text">Best smart devices and accessories for your digital lifestyle.</p>
    </div>
</section>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="filter-card">
                <h5 class="filter-title"><i class="fas fa-filter text-muted me-2"></i> Filter Search</h5>
                <form action="shop.php" method="GET">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Search by Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="iPhone, Samsung..." value="<?= $search_query ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Price Range ($)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?= $min_price ?>">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?= $max_price ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Sort By</label>
                        <select name="sort" class="form-select">
                            <option value="newest" <?= $sort_option == 'newest' ? 'selected' : '' ?>>Newest First</option>
                            <option value="price_asc" <?= $sort_option == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_desc" <?= $sort_option == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="oldest" <?= $sort_option == 'oldest' ? 'selected' : '' ?>>Oldest First</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Apply Filters</button>
                    <a href="shop.php" class="btn btn-outline-secondary w-100 mt-2 btn-sm">Reset</a>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">Found <strong><?= count($products_data) ?></strong> products</span>
            </div>

            <div class="row g-4">
                <?php if (count($products_data) > 0): ?>
                    <?php foreach($products_data as $row): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card card-product">
                                <div class="product-img-container">
                                    <img src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'images/no-image.png' ?>" 
                                         class="product-img" alt="<?= htmlspecialchars($row['name']) ?>">
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="product-title"><?= htmlspecialchars($row['name']) ?></h5>
                                    <p class="product-desc">
                                        <?= mb_strimwidth(htmlspecialchars($row['description']), 0, 80, "...") ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-end mt-auto">
                                        <div class="product-price">$<?= htmlspecialchars($row['price']) ?></div>
                                        <a href="add_to_cart.php?id=<?= $row['id'] ?>" class="btn btn-add-cart col-6">
                                            <i class="fas fa-cart-plus me-1"></i> Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-light text-center p-5 shadow-sm rounded">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4>No results found!</h4>
                            <p class="text-muted">Try changing search terms or removing price limits.</p>
                            <a href="shop.php" class="btn btn-primary mt-2">View All Products</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
