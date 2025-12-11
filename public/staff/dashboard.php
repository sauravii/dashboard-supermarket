<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 2) { 
    header("Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}

require_once('../../controllers/admin/user_controller.php');
require_once('../../controllers/admin/role_controller.php');
require_once('../../controllers/staff/product_controller.php');
require_once('../../controllers/staff/category_controller.php');
require_once('../../controllers/staff/brand_controller.php');
require_once('../../controllers/staff/supplier_controller.php');
require_once('../../controllers/staff/stock_controller.php');
require_once('../../controllers/staff/unit_controller.php');
require_once('../../controllers/staff/status_controller.php');

$users = read_users_controller();
$roles = read_roles_controller();
$products = read_product_controller();
$categories = read_categories_controller();
$brands = read_brand_controller();
$suppliers = read_suppliers_controller();
$stocks = read_all_stocks_controller();
$units = read_units_controller();
$statuses = read_status_controller();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Emoji -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
     <link rel="stylesheet" href="../../assets/css/admin_dashboard.css">

    <!-- JS -->
   <script src="../../assets/js/admin_dashboard.js" async></script>
</head>
<body>
    <!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><i class='bx bxs-smile icon'></i> AdminSite</a>
		<ul class="side-menu">
            <li><a href="#" class="menu-btn active" data-target="staff-content"><i class='bx bxs-widget icon'></i> Product & Category</a></li>
            <li><a href="#" class="menu-btn" data-target="staff-content"><i class='bx bxs-chart icon'></i> Stock Product</a></li>
            <li><a href="#" class="menu-btn" data-target="role-content"><i class='bx bxs-truck icon'></i> Supplier & Brand</a></li>
            <li><a href="#" class="menu-btn" data-target="role-content"><i class='bx bxs-report icon'></i> Restock History</a></li>
        </ul>
	</section>
	<!-- SIDEBAR -->

	<section id="content">
		<!-- NAVBAR -->
		<nav>
         <i class="bx bx-menu toggle-sidebar"></i>

         <form action="#">
            <div class="form-group">
               <input type="text" placeholder="Search..">
            </div>
         </form>

         <span class="divider"></span>

         <div class="profile">
            <img src="../../assets/images/img-profile.jpg" alt="" id="profile-ava">
            <div class="profile-link hidden" id="profile-link">
               <p class="greetings">Hello, <?= htmlspecialchars($_SESSION['username']) ?></p>
               <div class="logout">
                  <img src="../../assets/icons/ic-signout.svg" alt="" class="ic-logout" >
                  <p class="text-logout">Logout</p>
               </div>
            </div>
         </div>
      </nav>
		<!-- NAVBAR -->

      <!-- MAIN CONTENT -->
       <div class="main-content">
             <div id="dashboard-content" class="menu-content">
               <h1 class="main-title">Dashboard</h1>
               <a href="../logout.php">Dummy Logout</a>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Daftar Produk</h1>
               <table>
                  <thead>
                        <tr>
                           <th>Product ID</th>
                           <th>Product Name</th>
                           <th>Brand</th>
                           <th>Kategori</th>
                           <th>Supplier</th>
                           <th>Stok</th>
                           <th>Status</th>
                           <th>Aksi</th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($products as $product): ?>
                        <tr>
                           <td><?= $product['product_id'] ?></td>
                           <td><?= $product['product_name'] ?></td>
                           <td><?= $product['brand_name'] ?></td>
                           <td><?= $product['category_name'] ?></td>
                           <td><?= $product['supplier_name'] ?></td>
                           <td><?= $product['total_stock'] ?? 0 ?> <?= $product['unit_name'] ?? '' ?></td>
                           <td><?= $product['status_name'] ?></td>
                           <td>
                              <a href="./product/edit_product.php?id=<?= $product['product_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <a href="./product/delete_product.php?id=<?= $product['product_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                           </td>
                        </tr>
                  <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./product/add_product.php">
                  <button class="btn btn-add-user">
                        Tambah Produk
                  </button>
               </a>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Daftar Kategori</h1>
               <table>
                  <thead>
                     <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($categories as $category): ?>
                     <tr>
                        <td><?= $category['category_id'] ?></td>
                        <td><?= $category['category_name'] ?></td>
                        <td>
                        <a href="./category/edit_category.php?id=<?= $category['category_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="./category/delete_category.php?id=<?= $category['category_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                     </tr>
                  <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./category/add_category.php">
                  <button class="btn btn-add-user">
                     Tambah Kategori
                  </button>
               </a>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Tambah Stok</h1>

               <table>
                  <thead>
                     <tr>
                        <th>Product ID</th>
                        <th>Nama Produk</th>
                        <th>Stok Saat Ini</th>
                        <th>Unit Produk</th>
                        <th>Tambah Stok</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($stocks as $stock): ?>
                        <tr>
                        <form method="POST" action="../staff/stock/add_stock.php">
                           <td><?= $stock['product_id'] ?></td>
                           <td><?= $stock['product_name'] ?></td>
                           <td><?= $stock['total_stock'] ?></td>
                           <td><?= $stock['unit_name'] ?></td>
                           <td>
                              <input type="number" name="quantity" min="1" required>
                              <input type="hidden" name="product_id" value="<?= $stock['product_id'] ?>">
                              <input type="hidden" name="unit_id" value="<?= $stock['unit_id'] ?>">
                              <input type="hidden" name="supplier_id" value="<?= $stock['supplier_id'] ?>">
                           </td>
                           <td><button type="submit" class="btn btn-warning">Tambah</button></td>
                        </form>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Kurangi Stok</h1>

               <table>
                  <thead>
                     <tr>
                        <th>Product ID</th>
                        <th>Nama Produk</th>
                        <th>Stok Saat Ini</th>
                        <th>Unit Produk</th>
                        <th>Kurangi Stok</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($stocks as $stock): ?>
                        <tr>
                        <form method="POST" action="../staff/stock/remove_stock.php">
                           <td><?= $stock['product_id'] ?></td>
                           <td><?= $stock['product_name'] ?></td>
                           <td><?= $stock['total_stock'] ?></td>
                           <td><?= $stock['unit_name'] ?></td>
                           <td>
                              <input type="number" name="quantity" min="1" required>
                              <input type="hidden" name="product_id" value="<?= $stock['product_id'] ?>">
                              <input type="hidden" name="unit_id" value="<?= $stock['unit_id'] ?>">
                              <input type="hidden" name="supplier_id" value="<?= $stock['supplier_id'] ?>">
                           </td>
                           <td><button type="submit" class="btn btn-warning">Kurangi</button></td>
                        </form>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Daftar Supplier</h1>

                <table>
                  <thead>
                        <tr>
                           <th>Supplier ID</th>
                           <th>Supplier Name</th>
                           <th>Alamat</th>
                           <th>Nomor Telepon</th>
                           <th>Aksi</th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($suppliers as $supplier): ?>
                        <tr>
                           <td><?= $supplier['supplier_id'] ?></td>
                           <td><?= $supplier['supplier_name'] ?></td>
                           <td><?= $supplier['supplier_address'] ?></td>
                           <td><?= $supplier['supplier_phoneNum'] ?></td>
                           <td>
                              <a href="./supplier/edit_supplier.php?id=<?= $supplier['supplier_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <a href="./supplier/delete_supplier.php?id=<?= $supplier['supplier_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                           </td>
                        </tr>
                  <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./supplier/add_supplier.php">
                  <button class="btn btn-add-user">
                        Tambah Supplier
                  </button>
               </a>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Daftar Brand</h1>

               <table>
                  <thead>
                        <tr>
                           <th>Brand ID</th>
                           <th>Brand Name</th>
                           <th>Aksi</th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($brands as $brand): ?>
                        <tr>
                           <td><?= $brand['brand_id'] ?></td>
                           <td><?= $brand['brand_name'] ?></td>
                           <td>
                              <a href="./brand/edit_brand.php?id=<?= $brand['brand_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <a href="./brand/delete_brand.php?id=<?= $brand['brand_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                           </td>
                        </tr>
                  <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./brand/add_brand.php">
                  <button class="btn btn-add-user">
                        Tambah Brand
                  </button>
               </a>
            </div>

            <div id="staff-content" class="menu-content ">
               <h1 class="main-title">Histori Restock</h1>
            </div>   
       </div>
      <!-- MAIN CONTENT -->
	</section>
</body>
</html>
