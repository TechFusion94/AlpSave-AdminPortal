<?php
$uploads       = $uploads       ?? [];
$uploadErrors  = $uploadErrors  ?? [];
$uploadSuccess = $uploadSuccess ?? '';
?>
<div class="dash-layout">

    <?php $active = 'dataupload'; include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="dash-content">
        <div class="dash-header">
            <h1 class="dash-header__title">Data Upload</h1>
        </div>

        <div class="upload-widget">
            <h2>Upload a file</h2>

            <?php foreach ($uploadErrors as $error): ?>
                <p class="field-error"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php if ($uploadSuccess): ?>
                <div class="form-success-banner"><?= htmlspecialchars($uploadSuccess) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=dataupload" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880">

                <div class="form-group">
                    <label class="form-label" for="file">Choose image</label>
                    <input type="file" name="file" id="file" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label" for="alt">Alt text</label>
                    <input class="form-input" type="text" name="alt" id="alt">
                </div>
                <button type="submit" name="upload" class="btn btn--primary">Upload</button>
            </form>
        </div>

        <div class="upload-widget">
            <h2>Uploaded files</h2>
            <table class="data-table">
                <thead><tr><th>Preview</th><th>Alt text</th><th>Public URL</th></tr></thead>
                <tbody>
                <?php foreach ($uploads as $up): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($up['path']) ?>" alt="<?= htmlspecialchars($up['alt']) ?>" style="height:40px"></td>
                        <td><?= htmlspecialchars($up['alt']) ?></td>
                        <td><a href="<?= htmlspecialchars($up['path']) ?>" target="_blank"><?= htmlspecialchars($up['path']) ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>