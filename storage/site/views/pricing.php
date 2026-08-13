<?php
$username = $_SESSION['username'] ?? 'Admin';
$initial = strtoupper(substr($username, 0, 1));
$plans   = $plans   ?? [];
$errors  = $errors  ?? [];
$editing = $editing ?? null;
$token   = Csrf::token();
?>

<div class="dash-layout">

<?php $active = 'pricing'; include __DIR__ . '/partials/sidebar.php'; ?>


<main class="dash-content">
    <div class="dash-header">
        <h1 class="dash-header__title"><?= $editing ? 'Edit plan' : 'Update Pricing' ?></h1>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="form-error-banner">Please correct the highlighted fields below.</div>
    <?php endif; ?>

    <?php if (Role::can('manage_content')): ?>
        <form method="POST" action="index.php?page=pricing" class="upload-widget">

        <input type="hidden" name="csrf" value="<?= htmlspecialchars($token) ?>">

        <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">

        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= (int) $editing['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label class="form-label" for="name">Plan name</label>
            <input class="form-input <?= isset($errors['name']) ? 'form-input--error' : '' ?>"
                   type="text" id="name" name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? $editing['name'] ?? '') ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="price">Price (CHF)</label>
            <input class="form-input <?= isset($errors['price']) ? 'form-input--error' : '' ?>"
                   type="number" step="0.01" id="price" name="price"
                   value="<?= htmlspecialchars($_POST['price'] ?? $editing['price'] ?? '') ?>">
            <?php if (isset($errors['price'])): ?>
                <span class="field-error"><?= htmlspecialchars($errors['price']) ?></span>
            <?php endif; ?>
        </div>

        <?php $bp = $_POST['billing_period'] ?? $editing['billing_period'] ?? 'month'; ?>
        <div class="form-group">
            <label class="form-label" for="billing_period">Billing period</label>
            <select class="form-input form-select" id="billing_period" name="billing_period">
                <option value="month" <?= $bp === 'month' ? 'selected' : '' ?>>per month</option>
                <option value="year"  <?= $bp === 'year'  ? 'selected' : '' ?>>per year</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="tagline">Tagline</label>
            <input class="form-input" type="text" id="tagline" name="tagline"
                   value="<?= htmlspecialchars($_POST['tagline'] ?? $editing['tagline'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label" for="features">Features (one per line)</label>
            <textarea class="form-input" id="features" name="features" rows="4"><?= htmlspecialchars($_POST['features'] ?? $editing['features'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_featured" value="1"
                    <?= (($_SERVER['REQUEST_METHOD'] === 'POST') ? !empty($_POST['is_featured']) : !empty($editing['is_featured'])) ? 'checked' : '' ?>>
                <span>Highlight as featured plan</span>
            </label>
        </div>

        <div class="form-group">
            <label class="form-label" for="sort_order">Sort order</label>
            <input class="form-input" type="number" min="0" id="sort_order" name="sort_order"
                   value="<?= htmlspecialchars($_POST['sort_order'] ?? $editing['sort_order'] ?? '0') ?>">
        </div>

        <button type="submit" class="btn btn--primary">
            <?= $editing ? 'Save changes' : 'Add plan' ?>
        </button>
    </form>
    <?php endif; ?>

    <div class="upload-widget">
        <h2>Existing plans</h2>
        <table class="data-table">
            <thead>
            <tr><th>Name</th><th>Price</th><th>Featured</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td><?= htmlspecialchars($plan['name']) ?></td>
                    <td>CHF <?= htmlspecialchars($plan['price']) ?> / <?= htmlspecialchars($plan['billing_period']) ?></td>                    <td><?= $plan['is_featured'] ? '<span class="pill">★ Featured</span>' : '' ?></td>                    <td>
                        <?php if (Role::can('manage_content')): ?>
                            <a href="index.php?page=pricing&edit=<?= (int) $plan['id'] ?>" class="btn btn--primary">Edit</a>

                            <form method="POST" action="index.php?page=pricing"
                                  onsubmit="return confirm('Delete this plan?')" style="display:inline">
                                <input type="hidden" name="csrf"   value="<?= htmlspecialchars($token) ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id"     value="<?= (int) $plan['id'] ?>">
                                <button type="submit" class="btn btn--danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</div>