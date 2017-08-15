        <footer>
          <div class="pull-right">
            CMS Admin
          </div>
          <div class="clearfix"></div>
        </footer>
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= my_library::admin_js()?>jquery.min.js"></script>
    <script src="<?= my_library::admin_js()?>bootstrap.min.js"></script>
    <script src="<?= my_library::admin_js()?>fastclick.js"></script>
    <script src="<?= my_library::admin_js()?>nprogress.js"></script>
    <script src="<?= my_library::admin_js()?>custom.min.js"></script>
    <script src="<?= my_library::admin_js()?>pnotify.js"></script>
    <script src="<?= my_library::admin_js()?>sweetalert.min.js"></script>
    <script src="<?= my_library::admin_js()?>myadmin.js"></script>
    <?php if (!empty($extraJs)): ?>
      <?php foreach ($extraJs as $key => $value): ?>
        <script src="<?= my_library::admin_js().$value?>"></script>
      <?php endforeach ?>
    <?php endif ?>
    <?php $notify = $this->session->userdata('notify'); ?>
    <?php if (isset($notify)): ?>
      <?php $this->session->unset_userdata('notify'); ?>
      <script>
        $(document).ready(function(){
          new PNotify({
              title: '<?= $notify['title']?>',
              text: '<?= $notify['text']?>',
              type: '<?= $notify['type']?>',
              styling: 'bootstrap3'
            });
        });
      </script>
    <?php endif ?>
  </body>
</html>