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

      function showDetailTask(task) {
          console.log(task);
          $('#detail-title').html(task.title);
          $('#detail-date').html(task.date);
          $('#detail-deadline').html(task.deadline);
          //   $('#detail-attachment').html("<a href='<?= base_url('assets/attachment/') ?>" + task.attachment + "'>" + task.attachment + "</a>");
          $('#detail-attachment').html("<a href='../../assets/attachment/" + task.attachment + "'>" + task.attachment + "</a>");
          $('#detail-content').html(task.content);
      }

      function showEditTask(task) {
          console.log(task);
          $('#id').val(task.id);
          $('#id').prop('name', 'id');
          $('#title').val(task.title);
          console.log(toDate(task.deadline));
          $('#deadline').val(toDate(task.deadline));
          //   $('#attachment').val(task.attachment);
          $('.custom-file-label').html(task.attachment);
          $('textarea#content').val(task.content);
          $('form').prop('action', "<?= base_url('teacher/editTask') ?>");
      }

      function toDate(date) {
          let array = date.split(',');
          let splitDate = array[1].split(" ");
          let monthNum;
          if (getMonthFromString(splitDate[2]) < 10) {
              monthNum = '0' + getMonthFromString(splitDate[2]);

          } else {
              monthNum = getMonthFromString(splitDate[2]);

          }
          return splitDate[3] + "-" + monthNum + "-" + splitDate[1];
      }

      function getMonthFromString(mon) {
          return new Date(Date.parse(mon + " 1, 2012")).getMonth() + 1
      }

      function showDeleteTask(task) {
          console.log(task);
          $('#taskDelete').html(task.title);
          $('#idDelete').val(task.id);
          $('#subjectIdDelete').val(task.subject_id);

      }

      function showMark(data) {
          console.log(data);
          $('#id').val(data.id);
          $('#detail-name').html(data.name);
          $('#detail-class').html(data.student_class);
          $('#detail-status').html(data.submission_status);
          $('#detail-submission-date').html(data.submission_date);
          $('#detail-attachment').html(data.attachment);
          $('#detail-attachment').prop('href', '../../assets/attachment/' + data.attachment);
          $('#mark').val(data.mark);

      }

      $('#role_id').on('change', function() {
          let value = $('#role_id').val();
          showExtraForm(value);

      });

      function showExtraForm(value) {
          //student
          if (value == 2) {
              $('.student-form').css('display', 'block');
              $('#NISN').prop('required', 'true');
              $('#class').prop('required', 'true');
              $('#NIP').removeAttr('required');

              $('.teacher-form').css('display', 'none');
          }
          //teacher
          else if (value == 3) {
              $('.teacher-form').css('display', 'block');
              $('#NIP').prop('required', 'true');
              $('#NISN').removeAttr('required');
              $('#class').removeAttr('required');

              $('.student-form').css('display', 'none');
          } else {
              $('.teacher-form').css('display', 'none');
              $('.student-form').css('display', 'none');
          }
      }

      function showAddUser() {
          $('#exampleModalLabel').html('Add New User');
          $('form').trigger("reset");
      }

      function showEditUser(data) {
          console.log(data);
          $('#edit-id').val(data.id);
          $('#edit-name').val(data.name);
          $('#edit-email').val(data.email);
          $('#edit-is_active').val(data.is_active);
          $('#edit-role_name').val(data.role_name);
          $('#edit-role_id').val(data.role_id);

          $('#edit-NISN').val(data.NISN);
          $('#edit-class').val(data.class);

          $('#edit-NIP').val(data.NIP);
          $('#edit-teacher_id').val(data.teacher_id);


          var html_element = "";
          var wrapper = $("#subject-array");
          $(wrapper).html(html_element);

          for (let i = 0; i < data.teacher.length; i++) {
              html_element =
                  `
          <div class="subject-array">
                            <div class="row mb-2 subject-content">
                                <div class="col">
                                    <label for="Subject">Subject</label>
                                    <select class="form-control subject_id" id='id-` + i + `' name="subject_id[]" required>
                                        <?php foreach ($subject as $s) { ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                             <input type="text" name="teacher_subject_id[]" id='teacher_subject-` + i + `' hidden>
                            </div>
                        </div>`;

              $(wrapper).append(`<div class="mb-2">` + html_element + `<a href="#" id=delete-` + i + ` class="delete text-danger mb-2">Delete</a></div>`);
              $('select#id-' + i).val(data.teacher[i].subject);
              $('#teacher_subject-' + i).val(data.teacher[i].teacher_subject_id);
              if (data.teacher.length > 0) {
                  $('a#delete-0').remove();
              }
              //   $('.subject_id').val(data.teacher[i].subject);
              //   console.log(data.teacher[i].subject);
          }

          showExtraForm(data.role_id);
      }

      // for edit
      $(document).ready(function() {
          var max_fields = 10;
          var wrapper = $("#subject-array");
          var add_button = $("#edit_subject");
          var html_element =
              `
          <div class="subject-array">
                            <div class="row mb-2 subject-content">
                                <div class="col">
                                    <label for="Subject">Subject</label>
                                    <select class="form-control subject_id" name="subject_id[]" required>
                                        <option value="">Choose subject..</option>
                                        <?php foreach ($subject as $s) { ?>
                                            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>
                        </div>`

          ;
          var x = 1;

          $(add_button).click(function(e) {
              console.log('bisa');
              e.preventDefault();
              if (x < max_fields) {
                  x++;
                  $(wrapper).append(`<div class="mb-2">` + html_element + '<a href="#" class="delete text-danger mb-2">Delete</a></div>');
              } else {
                  alert('You Reached the limits')
              }
          });

          $(wrapper).on("click", ".delete", function(e) {
              console.log(x);
              e.preventDefault();
              $(this).parent('div').remove();
              //   console.log($(this).parent('div'));
              x--;
          })
      });


      function showDeleteUser(data) {
          $('#delete-id').val(data.id);
          $('#delete-role_id').val(data.role_id);
          $('#delete-name').html(data.name);
      }


      $(document).ready(function() {
          var max_fields = 10;
          var wrapper = $(".subject-array");
          var add_button = $("#add_subject");
          var html_element = wrapper.html();
          var x = 1;

          $(add_button).click(function(e) {
              console.log('bisa');
              e.preventDefault();
              if (x < max_fields) {
                  x++;
                  $(wrapper).append(`<div class="mb-2">` + html_element + '<a href="#" class="delete text-danger mb-2">Delete</a></div>');
              } else {
                  alert('You Reached the limits')
              }
          });

          $(wrapper).on("click", ".delete", function(e) {
              console.log(x);
              e.preventDefault();
              $(this).parent('div').remove();
              //   console.log($(this).parent('div'));
              x--;
          })
      });

      function showAddSubject() {
          $('#exampleModalLabel').html('Add New Subject');
          $('#submit').html('Submit');
          $('form').trigger("reset");
      }

      function showEditSubject(data) {
          $('#exampleModalLabel').html('Edit Subject');
          $('#submit').html('Edit');

          $('#id').val(data.id);
          $('#name').val(data.name);
          $('#cluster').val(data.cluster);
          $('#subjectForm').prop('action', '<?= base_url('admin/editSubject') ?>');

      }

      function showDeleteSubject(data) {
          $('#delete-id').val(data.id);
          $('#delete-name').html(data.name);
      }
  </script>
  <script src="<?= base_url('assets/js/custom.js') ?>"></script>
  </body>

  </html>