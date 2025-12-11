<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 1) { 
    header("Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}

require_once('../../controllers/admin/user_controller.php');
require_once('../../controllers/admin/role_controller.php');

$users = read_users_controller();
$roles = read_roles_controller();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Emoji -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
     <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <!-- JS -->
   <script src="../../assets/js/dashboard.js" async></script>
</head>
<body>
    <!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><i class='bx bxs-smile icon'></i> AdminSite</a>
		<ul class="side-menu">
         <li><a href="#" class="menu-btn active" data-target="staff-content"><i class='bx bxs-widget icon'></i> Kelola Staff </a></li>
         <li><a href="#" class="menu-btn" data-target="role-content"><i class='bx bxs-chart icon'></i>Kelola Role</a></li>
      </ul>
	</section>
	<!-- SIDEBAR -->

	<section id="content">
		<!-- NAVBAR -->
		<nav>
         <i class="bx bx-menu toggle-sidebar"></i>

         <form action="#">
            <div class="form-group">
               <input type="text" placeholder="Cari..">
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
               <h1 class="main-title">Daftar Pengguna</h1>
               <table>
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($users as $user): ?>
                        <tr>
                           <td><?= $user['user_id'] ?></td>
                           <td><?= $user['username'] ?></td>
                           <td><?= $user['password'] ?></td>
                           <td><?= $user['role_id'] ?></td>
                           <td><?= $user['created_at'] ?></td>
                           <td>
                              <a href="./user/edit_user.php?id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <a href="./user/delete_user.php?id=<?= $user['user_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./user/add_user.php">
                  <button class="btn btn-add-user">
                     Tambah Pengguna
                  </button>
               </a>
            </div>

            <div id="role-content" class="menu-content">
               <h1 class="main-title">Daftar Role</h1>
               <table>
                  <thead>
                     <tr>
                        <th>Role ID</th>
                        <th>Jenis Role</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($roles as $role): ?>
                        <tr>
                           <td><?= $role['role_id'] ?></td>
                           <td><?= $role['role_name'] ?></td>
                           <td><?= $role['created_at'] ?></td>
                           <td>
                              <a href="./role/edit_role.php?id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                              <!-- <a href="./role/delete_role.php?id=<?= $user['user_id'] ?>" class="btn btn-danger btn-sm">Hapus</a> -->
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>

               <a href="./role/add_role.php">
                  <button class="btn btn-add-user">
                     Tambah Role
                  </button>
               </a>
            </div> 
       </div>
      <!-- MAIN CONTENT -->
	</section>
</body>
</html>
