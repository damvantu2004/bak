</div>
<!-- /.card-body -->

</div>
<!-- /.card -->
</div>
</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <div class="d-none d-sm-block" style="float: right">
        <b>D15CNPM2</b>
    </div>
    Đinh Tùng Dương ,Phạm Hồng Định, Trần Tuấn Kiệt
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- sidebar helper -->
<script src="./public/admin/plugins/sidebar/sidebar.js"></script>

<!-- overlayScrollbars -->
<script src="./public/admin/plugins/overlayScrollbars/js/overlayScrollbars.js"></script>
<!-- AdminLTE App -->
<script src="./public/admin/dist/js/adminlte.js"></script>

<!-- Form validation -->
<script src="./public/site/js/validate.js"></script>

<script>
    const actualBtn = document.getElementById('actual-btn');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function() {
        fileChosen.textContent = this.files[0].name
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)

            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>

</html>