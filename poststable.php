<?php ob_start();

@include 'db_connect.php';

session_start();
$id = $_SESSION['login_id'];
if (!isset($id)) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Posts - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="admin.php">Farm&Cust</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <!-- Navbar-->
    <ul class="w-100 navbar-nav ms-auto ms-md-0 me-3 me-lg-4 justify-content-end">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="admin.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
            </a>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
              Pages
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                  Tables
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="usertables.php">Users</a>
                    <a class="nav-link" href="poststable.php">Posts</a>
                    <a class="nav-link" href="commentstable.php">Comments</a>
                  </nav>
                </div>
              </nav>
            </div>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          ADMIN
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Posts</h1>

        </div>
        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
          </div>
          <div class="card-body">
            <table id="datatablesSimple">
              <thead>
                <tr>
                  <th>Post</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Firstname</th>
                  <th>Surname</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Location</th>
                  <th>User Type</th>
                </tr>
              </tfoot>
              <tbody><?php
                      $query = "SELECT * FROM users";
                      $query_run = mysqli_query($conn, $query);


                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $user) {
                          $id = $user['user_id'];
                          $select = " SELECT * FROM users WHERE user_id = '$id'";
                          $result = mysqli_query($conn, $select);
                          // $type = mysqli_num_rows($result);

                      ?>
                    <tr>
                      <td><?= $user['user_firstname']; ?></td>
                      <td><?= $user['user_lastname']; ?></td>
                      <td><?= $user['user_email']; ?></td>
                      <td><?= $user['user_contact']; ?></td>
                      <td><?= $user['user_address']; ?></td>
                      <td>
                        <form action="../code.php" method="POST" class="d-inline">
                          <button type="submit" name="delete_user" value="<?= $user['user_id']; ?>" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                      </td>
                    </tr>
                <?php
                        }
                      } else {
                        echo "<h5> No Record Found </h5>";
                      } ?>

              </tbody>
            </table>
          </div>
        </div>
    </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
      <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; Farm$cust 2022</div>
        </div>
      </div>
    </footer>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>