<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all country Data
    $stmt = $conn->prepare("SELECT * FROM country");
    $stmt->execute();
    $countries = $stmt->fetchAll();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h2 class="page-title bold">Countries</h2>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="./"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Countries</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Start -->
                <div class="row">
                    <!-- Advance Table Card-->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card table-card">
                            <div class="card-body">
                                <form class="separate-form" action="php/insert.php?type=post" method="POST" enctype="multipart/form-data">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="country_name" class="col-form-label">Country Name</label>
                                                    <input class="form-control" type="text" placeholder="Enter Country Name" name="country_name" id="country_name" >
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="ip_address" class="col-form-label">Ip Address</label>
                                                    <input class="form-control" type="text" placeholder="Enter Ip Address" name="ip_address" id="ip_address" >
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" name="submit" value="Add" style="float:right;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="chart-holder">
                                <div class="table-responsive mt-3">
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
                                                    <th scope='col'>Ip Address</th>
                                                    <th scope='col' colspan="2">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $countnum = 0;
                                                    foreach ($countries as $country) :
                                                    echo $country['status'] == 0 ? "<tr style='background:#f1f2f6; '>" : "<tr>";
                                                    $countnum++
                                                ?>
                                                    <td>
														<div class="checkbox">
															<input id="checkbox<?= $countnum ?>" type="checkbox" name="<?= $country['country_id'] ?>">
															<label for="checkbox<?= $countnum ?>"></label>
														</div>
													</td>
                                                    <td><?= $countnum ?></td>
                                                    <td>
                                                        <input type="text" style="border:0px;" value="<?= $country['country_name'] ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="text" style="border:0px;" value="<?= $country['ip_address'] ?>" />
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
                                                                    <a href="javascript:void(0);" onclick="editCountry(<?= $country['country_id'] ?>)">
                                                                        <i class="far fa-edit mr-2" aria-hidden="true"></i> Save
                                                                    </a>
                                                                </li>
                                                                
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="deleteCountry(<?= $country['country_id'] ?>)">
                                                                        <i class="far fa-trash-alt mr-2" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <?php if($country['status'] == 0)
                                                                    {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="activateCountry(<?= $country['country_id'] ?>)">
                                                                        <i class="" aria-hidden="true"></i> Activate
                                                                    </a>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                    <a href="javascript:void(0);" onclick="deactivateCategory(<?= $country['country_id'] ?>)">
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