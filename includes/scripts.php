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
        function reloadObj(idName)
        {
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

        function myFunction(x) {
            x.classList.toggle("fa-thumbs-down");
        }
        
        function myFunctionUn_Follow(x)
        {
            alert("Eeasds");
        }
    </script>

    </body>

</html>