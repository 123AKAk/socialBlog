<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all AUTHOR Data
    $stmt = $conn->prepare("SELECT * FROM author");
    $stmt->execute();
    $authors = $stmt->fetchAll();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h2 class="page-title bold">All Authors</h2>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">All Authors</li>
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
                            <div class="col">
                                <!-- feedback message -->
                                <?php include 'includes/feedbackmsg.php'; ?>
                            </div>
                            <div class="card-body">
                                <div class="chart-holder">
                                <div class="table-responsive">
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
                                                    <th scope='col'>Avatar</th>
                                                    <th scope='col'>Full Name</th>
                                                    <th scope='col'>Description</th>
                                                    <th scope='col'>Twitter</th>
                                                    <th scope='col'>Instagram</th>
                                                    <th scope='col'>Facebook</th>
                                                    <th scope='col'>Email</th>
                                                    <th scope='col' colspan="3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $countnum = 0;
                                                foreach ($authors as $author) :
                                                    if($author['type'] == 0)
                                                    {
                                                        echo $author['type'] == 0 ? "<tr style='background:#f1f2f6; '>" : "<tr>";
                                                    }
                                                    else if($author['type'] == 2)
                                                    {
                                                        echo "<tr style='background:#b3b4b6; '>";   
                                                    }
                                                    $countnum++
                                                    ?>
                                                    <td>
														<div class="checkbox">
															<input id="checkbox<?= $countnum ?>" type="checkbox" name="<?= $author['author_id'] ?>">
															<label for="checkbo<?= $countnum ?>"></label>
														</div>
													</td>
                                                    <td><?= $countnum ?></td>
                                                    <td>
                                                        <span >
                                                            <img src="../img/avatar/<?= $author['author_avatar'] == "" ? "noimage.jpg" : $author['author_avatar'] ?>" style="width: 100px; height: auto;">
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= $author['author_fullname'] ?>
                                                    </td>
                                                    <td>
                                                        <?= strip_tags(substr($author['author_desc'], 0, 15)) . "..." ?>
                                                    </td>
                                                    <td>
                                                        <a href="https://twitter.com/<?= $author['author_twitter'] ?>" target="_blank">
                                                            <i class="fa fa-twitter"></i> <?= $author['author_twitter'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://instagram.com/<?= $author['auth_instagram'] ?>" target="_blank">
                                                            <i class="fa fa-instagram"></i> <?= $author['auth_instagram'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://facebook.com/<?= $author['auth_facebook'] ?>" target="_blank">
                                                            <i class="fa fa-facebook"></i> <?= $author['auth_facebook'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="mailto:<?= $author['author_email'] ?>" target="_blank">
                                                            <i class="fa fa-mail"></i> <?= $author['author_email'] ?>
                                                        </a>
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
                                                                    <a href="../author.php?authid=<?=  $components->protect($author['author_id']) ?>" target="_blank">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="update_author.php?id=<?= $author['author_id'] ?> ">
                                                                        <i class="far fa-edit mr-2" aria-hidden="true"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="../assets/delete.php?type=author&id=<?= $author['author_id'] ?> ">
                                                                        <i class="far fa-trash-alt mr-2" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                                <?php if($author['type'] != 0){ ?>
                                                                <li>
                                                                    <a href="../assets/update.php?type=banauthor&id=<?= $author['author_id'] ?> ">Ban</a>
                                                                </li>
                                                                <?php }else { ?>
                                                                <li>
                                                                    <a href="../assets/update.php?type=approve&id=<?= $author['author_id'] ?> ">
                                                                        <i class="far fa-check-square " aria-hidden="true"></i> Accept
                                                                    </a>
                                                                </li>
                                                                <?php } ?>

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