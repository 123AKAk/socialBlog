    <!--plugins -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> -->
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/masonry.min.js"></script>
    <script src="assets/js/theia-sticky-sidebar.min.js"></script>
    <script src="assets/js/ajax-contact.js"></script>
    <script src="assets/js/switch.js"></script>

    <!-- Select2 -->
    <script src="assets/select2/js/select2.full.min.js"></script>
    <!-- alertify -->
    <script src="assets/alertify/alertify.js"></script>

    <!-- JS main  -->
    <script src="assets/js/main.js"></script>
    <script src="scripts/code.js"></script>

    <script>
        function reloadObj(idName) {
            let section = document.getElementById(idName);
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let newDocument = parser.parseFromString(html, 'text/html');
                    let newSection = newDocument.getElementById(idName);
                    section.innerHTML = newSection.innerHTML;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function like_dislikePost(postId, userId, action, element) {
            let formdata = new FormData();
            formdata.append("userId", userId);
            formdata.append("postId", postId);
            formdata.append("action", action);
            fetch("classes/components/userComponents.php?dataPurpose=postDetails", {
                    method: "POST",
                    body: formdata,
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    let result = (data);
                    if(element != "")
                    {
                        if (result.response == true) {
                            objData = JSON.parse(result.data);
                            if (objData.likes == 1 && objData.dislikes == 0) {
                                let element2 = document.getElementById("dislikePost");

                                element2.style.background = "#ebe846";

                                element.style.background = "#0e100fbf";
                            } else if (objData.likes == 0 && objData.dislikes == 1) {
                                let element2 = document.getElementById("likePost");

                                element2.style.backgroundColor = "#ebe846";

                                element.style.backgroundColor = "#0e100fbf";
                            } else {
                                element.style.backgroundColor = "#ebe846";
                            }
                        } else {
                            alertify.error(result.message);
                        }
                    }
                })
                .catch(error =>
                    console.log(error)
                );
        }

        function Un_FollowAuthor(authorId, userId, action, element) {
            let formdata = new FormData();
            formdata.append("userId", userId);
            formdata.append("authorId", authorId);
            formdata.append("action", action);
            fetch("classes/components/userComponents.php?dataPurpose=follow_unfollow_Author", {
                    method: "POST",
                    body: formdata,
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    let result = (data);
                    if (result.response == true) {
                        //change icon style
                        if (result.data == 1) {
                            element.style.backgroundColor = "#0e100fbf";
                            element.innerHTML = '<i class="fas fa-user-minus"></i>';
                            element.setAttribute("onclick", `Un_FollowAuthor('${authorId}', '${userId}', 'remove', this)`)
                        } else if (result.data == 0) {
                            element.style.backgroundColor = "#ebe846";
                            element.innerHTML = '<i class="fas fa-user-plus"></i>';
                            element.setAttribute("onclick", `Un_FollowAuthor('${authorId}', '${userId}', 'add', this)`)
                        } else {
                            element.style.backgroundColor = "#ebe846";
                            element.innerHTML = '<i class="fas fa-user-plus"></i>';
                            element.setAttribute("onclick", Un_FollowAuthor(authorId, userId, 'add', this))
                        }
                    } else {
                        alertify.error(result.message);
                    }
                })
                .catch(error =>
                    console.log(error)
                );
        }

        function Un_BookmarkPost(postId, userId, action, element) {
            let formdata = new FormData();
            formdata.append("userId", userId);
            formdata.append("postId", postId);
            formdata.append("action", action);
            fetch("classes/components/userComponents.php?dataPurpose=bookmark_unbookmark_Post", {
                    method: "POST",
                    body: formdata,
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    let result = (data);
                    if (result.response == true) {
                        //change icon style
                        if (result.data == 1) {
                            element.style.backgroundColor = "#0e100fbf";
                            element.setAttribute("onclick", `Un_BookmarkPost('${postId}', '${userId}', 'remove', this)`)
                        } else if (result.data == 0) {
                            element.style.backgroundColor = "#ebe846";
                            element.setAttribute("onclick", `Un_BookmarkPost('${postId}', '${userId}', 'add', this)`)
                        } else {
                            element.style.backgroundColor = "#ebe846";
                            element.setAttribute("onclick", `Un_BookmarkPost('${postId}', '${userId}', 'add', this)`)
                        }
                    } else {
                        alertify.error(result.message);
                    }
                })
                .catch(error =>
                    console.log(error)
                );
        }

        function makelogin() {
            alertify.message("Log in to use user Privileges.");
        }
    </script>

    </body>

    </html>