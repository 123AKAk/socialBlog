<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all category Data
    $stmt = $conn->prepare("SELECT * FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h2 class="page-title bold">Post Categories</h2>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="./"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Post Categories</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <p>The Category Name and Description can be edited by clicking on it's text to make changes</p>
                </div>

                <!-- Table Start -->
                <div class="row">
                    <!-- Advance Table Card-->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card table-card">
                           
                            <div class="card-body">
                                <div class="chart-holder">
                                <div class="table-responsive" style="height:500px">
                                        <table class="table table-styled mb-0">
                                            <thead>
                                                <tr>
                                                    <th>
														<div class="checkbox">
															<input id="checkbox0" type="checkbox">
															<label for="checkbox0"></label>
														</div>
													</th>
                                                    <th>S/N</th>
                                                    <th scope='col'>Name</th>
                                                    <th scope='col'>Description</th>
                                                    <th scope='col'>Date Created</th>
                                                    <th scope='col' colspan="2">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $countnum = 0;
                                                    foreach ($categories as $category) :
                                                    echo "<tr>";
                                                    $countnum++
                                                ?>
                                                    <td>
														<div class="checkbox">
															<input id="checkbox<?= $countnum ?>" type="checkbox" name="<?= $category['id'] ?>">
															<label for="checkbox<?= $countnum ?>"></label>
														</div>
													</td>
                                                    <td><?= $countnum ?></td>
                                                    <td>
                                                        <input type="text" style="border:0px;" value="<?= $category['category_name'] ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="border:0px;" value="<?= $category['category_desc'] ?>" />
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <?= $category['category_creation_date'] ?>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <?= $category['category_update_date'] ?>
                                                        </p>
                                                    </td>

                                                    <td class="relative">
                                                        <a class="action-btn " href="javascript:void(0); ">
                                                            <svg class="default-size "  viewBox="0 0 341.333 341.333 ">
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                            <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                            <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                        <div class="action-option ">
                                                            
                                                            <ul>
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="editCategory(<?= $category['id'] ?>)">
                                                                        <i class="far fa-edit mr-2" aria-hidden="true"></i> Edit
                                                                    </a>
                                                                </li>
                                                                
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="deleteCategory(<?= $category['id'] ?>)">
                                                                        <i class="far fa-trash-alt mr-2" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <?php if($category['status'] == 0)
                                                                    {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="activateCategory(<?= $category['id'] ?>)">
                                                                        <i class="" aria-hidden="true"></i> Activate
                                                                    </a>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="deactivateCategory(<?= $category['id'] ?>)">
                                                                        <i class="" aria-hidden="true"></i> Deactivate
                                                                    </a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </li>
                                                                
                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php
                                                    echo "</tr>";
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>