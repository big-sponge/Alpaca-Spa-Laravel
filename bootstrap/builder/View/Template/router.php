

/*
|--------------------------------------------------------------------------
| <?php echo $this->className."\n"; ?>
|--------------------------------------------------------------------------
*/

/* admin - get<?php echo $this->className; ?>List */
Route::any('<?php echo $this->classNameLc; ?>/get<?php echo $this->className; ?>List', "<?php echo $this->className; ?>Controller@get<?php echo $this->className; ?>List");

/* admin - edit<?php echo $this->className; ?> */
Route::any('<?php echo $this->classNameLc; ?>/edit<?php echo $this->className; ?>', "<?php echo $this->className; ?>Controller@edit<?php echo $this->className; ?>");

/* admin - delete<?php echo $this->className; ?> */
Route::any('<?php echo $this->classNameLc; ?>/delete<?php echo $this->className; ?>', "<?php echo $this->className; ?>Controller@delete<?php echo $this->className; ?>");