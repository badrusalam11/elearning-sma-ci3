  <!-- Footer -->
  <footer class="sticky-footer bg-white">
      <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Copyright &copy; WPU Login <?php echo date('Y') ?> </span>
          </div>
      </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <div class="modal-body">Are you sure want to logout?</div>
              <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
              </div>
          </div>
      </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
  <!-- <script src="<?= base_url('assets/js/icon.js') ?>"></script> -->

  <script>
      $('.accessCheck').on('click', function() {
          const menuId = $(this).data('menu');
          const roleId = $(this).data('role');
          console.log(menuId);
          console.log(roleId);
          $.ajax({
              url: "<?= base_url('admin/changeAccess') ?>",
              type: "POST",
              data: {
                  roleId: roleId,
                  menuId: menuId
              }
          }).done((result) => {
              document.location.href = "<?= base_url('admin/roleaccess/') ?>" + roleId;
          }).fail((error) => {
              alert('gagal');
          })
      });

      $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass('selected').html(fileName);

          // preview image
          var file = $("input[type=file]").get(0).files[0];
          var reader = new FileReader();
          reader.onload = function() {
              $(".img-thumbnail").attr("src", reader.result);
          }
          reader.readAsDataURL(file);

      });

      function showAddMenu() {
          $('#exampleModalLabel').html('Add New Menu');
          $('#submit').html('Submit');
      }

      function showEditMenu(menu) {
          $('#exampleModalLabel').html('Edit Menu');
          $('form').prop('action', 'menu/editMenu');
          $('#submit').html('Edit');
          $('#id').val(menu.id);
          $('#menu').val(menu.menu);
      }

      function showDeleteMenu(menu) {
          //console.log(menu);
          $('#idDelete').val(menu.id);
          $('#menuDelete').html(menu.menu);

      }

      function showAddSubMenu() {
          $('#exampleModalLabel').html('Add New Sub Menu');
          $('#submit').html('Submit');
      }

      function showEditSubMenu(menu) {
          //   console.log(menu);
          $('#exampleModalLabel').html('Edit New Sub Menu');
          $('form').prop('action', 'editSubMenu');
          $('#submit').html('Edit');
          //set value
          $('#id').val(menu.id);
          $('#title').val(menu.title);
          $('#menu_id').val(menu.menu_id);
          $('#url').val(menu.url);
          $('#icon').val(menu.icon);
          //   $('#is_active').val(menu.is_active);
          if (menu.is_active == 0) {
              $('#is_active').prop('checked', '');
          } else {
              $('#is_active').prop('checked', 'checked');

          }
      }

      function showDeleteSubMenu(menu) {
          console.log(menu);
          $('#idDelete').val(menu.id);
          $('#menuDelete').html(menu.title);

      }

      function showInsertRole() {
          $('#exampleModalLabel').html('New Role');
          $('form').prop('action', 'roleInsert');
          $('#submit').html('Submit');
          $('#role').val('');
      }

      function showEditRole(role) {
          $('#exampleModalLabel').html('Edit Role');
          $('form').prop('action', 'roleEdit');
          $('#submit').html('Edit');
          $('#role').val(role.name);
          $('#id').val(role.id);
      }

      function showDeleteRole(role) {
          console.log(role);
          $('#idDelete').val(role.id);
          $('#roleDelete').html(role.name);

      }

  </script>
  <script src="<?= base_url('assets/js/custom.js')?>"></script>
  </body>

  </html>