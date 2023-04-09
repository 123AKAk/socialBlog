    <!-- startUp modal -->
    <div class="modal fade" id="startUpToogle" aria-hidden="true" aria-labelledby="startUpToogleLabel" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="startUpToogleLabel">Select your Country</h5>
                </div>
                <div class="container text-center justify-content-center" style="width:100%;">
                    <div class="spinner-border spinner-border-sm " role="status" id="counSpiner">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="form-group" id="counHolder" style="display:none;">
                        <!-- <label>Select your Country</label> -->
                        <select class="form-control" id="userCountryList" style="width:100%;" onchange="getSelectedCountry(this)">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Enter" onclick="setUserCountry()">Enter</button>
                </div>
            </div>
        </div>
    </div>
    <!-- startUp modal -->

    <!--footer-->
    <footer class="footer">
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright">
                            <p>© Copyright 2023 <a href="https://www.bluntechnology.com">Blunt Technology</a>, All rights reserved.</p>
                        </div>
                        <div class="back">
                            <a href="#" class="back-top">
                                <i class="fas fa-arrow-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!--Search-form-->
        <div class="search">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 m-auto col-md-8 col-sm-11">
                        <div class="search-width  text-center">
                            <button type="button" class="close">
                                <i class="fas fa-times"></i>
                            </button>
                            <form class="search-form" action="search.php" method="get">
                                <input type="search" name="keywrd" value="" placeholder="What are you looking for?">
                                <button type="submit" class="search-btn">search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/-->
    </div>