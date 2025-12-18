<?php 
require_once 'includes/admin_header.php'; 
require_once '../includes/db_connect.php';

// For now, this form is only for ADDING new images. Editing can be a future enhancement.
$page_title = 'Add New Gallery Image';
$form_action = 'gallery_actions.php?action=add';
?>

<!-- The main white container for the page -->
<div style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

    <!-- The header section inside the white box -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <h1 style="font-family: 'Montserrat', sans-serif; margin: 0;"><?php echo $page_title; ?></h1>
        <a href="manage_gallery.php" style="background-color: #231F20; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 700;">← Back to Gallery</a>
    </div>

    <!-- The form container, centered with a max-width -->
    <div style="max-width: 800px; margin: 0 auto;">
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            
            <div style="margin-bottom: 25px;">
                <label for="image" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Image File</label>
                <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" required>
                <small style="display: block; color: #777; margin-top: 8px;">Select the image you want to upload. Required.</small>
            </div>

            <div style="margin-bottom: 25px;">
                <label for="caption" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Caption</label>
                <input type="text" id="caption" name="caption" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                <small style="display: block; color: #777; margin-top: 8px;">A short description of the image.</small>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label for="category" style="display: block; margin-bottom: 8px; font-weight: 700; color: #555;">Category</label>
                <select id="category" name="category" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; background-color: #fdfdfd;">
                    <option value="">-- Select a Category --</option>
                    <option value="Facilities">Facilities</option>
                    <option value="Team">Team</option>
                    <option value="Events">Events</option>
                </select>
                <small style="display: block; color: #777; margin-top: 8px;">Assigning a category allows users to filter images on the public gallery page.</small>
            </div>

            <div style="margin-bottom: 25px;">
                <button type="submit" style="display: inline-block; cursor: pointer; border: none; padding: 12px 30px; font-size: 1.1rem; background-color: #00A0B0; color: #fff; border-radius: 5px; font-weight: 700;">Upload Image</button>
            </div>

        </form>
    </div>
</div>

<?php 
$conn->close();
require_once 'includes/admin_footer.php'; 
?>

