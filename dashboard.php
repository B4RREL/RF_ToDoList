<?php 
session_start();
require_once "./template/header.php"; 
?>

    <section>
            <nav class="navbar navbar-expand-lg bg-transparent fixed-top">
                <div class="container-sm-fluid container-md">
                    <a class="navbar-brand text-primary font-script" href="#">CRUD Project with pure PHP</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active text-primary" aria-current="page" href="./dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="./create.php">Create</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="./logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
    </section>

    <section class="min-vh-100 container-fluid container-md">
        <div class="pt-9 pt-md-6 mx-3">
            <h3 class="text-secondary display-6">To do Lists</h3>
            <?= $_SESSION['userID'][7] ?>
            <table class="table table-striped">
                <thead>
                    <tr class="row">
                        <th class="text-secondary col-4">Title</th>
                        <th class="text-secondary col-4">Deadline</th>
                        <th class="text-secondary col-2">Done</th>
                        <th class="text-secondary col-2">Option</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr class='row'>
                        <td class='text-secondary col-4'>Cooking</td>
                        <td class='text-secondary col-4'>12.2.2023</td>
                        <td class='ps-4 col-2'>
                            <form action=''>
                                <input type='checkbox' name='' class='form-check' $checked >
                            </form>
                        </td>
                        <td class='text-secondary col-2 d-flex'>
                            <a href=''>
                                <i class='bi bi-pencil-square me-3'></i>
                            </a>
                            <a href=''>
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>
                    <tr class='row'>
                        <td class='text-secondary col-4'>Cooking</td>
                        <td class='text-secondary col-4'>12.2.2023</td>
                        <td class='ps-4 col-2'>
                            <form action=''>
                                <input type='checkbox' name='' class='form-check' $checked >
                            </form>
                        </td>
                        <td class='text-secondary col-2 d-flex'>
                            <a href=''>
                                <i class='bi bi-pencil-square me-3'></i>
                            </a>
                            <a href=''>
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>
                    <tr class='row'>
                        <td class='text-secondary col-4'>Cooking</td>
                        <td class='text-secondary col-4'>12.2.2023</td>
                        <td class='ps-4 col-2'>
                            <form action=''>
                                <input type='checkbox' name='' class='form-check' $checked >
                            </form>
                        </td>
                        <td class='text-secondary col-2 d-flex'>
                            <a href=''>
                                <i class='bi bi-pencil-square me-3'></i>
                            </a>
                            <a href=''>
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

<?php
    require_once "./template/footer.php"
?>