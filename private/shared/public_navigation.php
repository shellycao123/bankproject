<nav>
  <?php $nav_subjects = find_all_subjects(["visible" => $visible]); ?>
  <ul class="subjects">
    <?php while($nav_subject = mysqli_fetch_assoc($nav_subjects)) { ?>


      <li<?php
      if(isset($page['subject_id']) && $page['subject_id'] == $nav_subject['id']){
          echo " class = 'selected' ";
      }
      ?>>
        <a href="<?php echo url_for('index.php?subject_id=' . u($nav_subject['id'])); ?>">
          <?php echo h($nav_subject['menu_name']); ?>
        </a>

          <?php if( isset($page) && $page['subject_id'] == $nav_subject['id']){?>
          <ul class = 'pages'>
          <?php
          $nav_pages = find_all_pages_by_subject_id($nav_subject['id'], ['visible' => $visible]);
          while ($nav_page = mysqli_fetch_assoc($nav_pages)) {
              ?>
              <li
                  <?php
                  if (isset($page['id']) && $page['id'] == $nav_page['id']) {
                      echo "class = 'selected'";
                  }
                  ?>>
                  <a href='<?= url_for('index.php?page_id=' . h(u($nav_page['id']))); ?>'>
                      <?= $nav_page['menu_name']; ?>
                  </a>
              </li>
          <?php }; ?>
          </ul>
          <?php mysqli_free_result($nav_pages);
          } ?>
      </li>

    <?php } // while $nav_subjects ?>
  </ul>
  <?php mysqli_free_result($nav_subjects); ?>
</nav>
