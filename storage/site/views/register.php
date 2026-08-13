<?php

$step = $_SESSION['register_step'] ?? 1;   // default to step 1 on first visit
$data = $_SESSION['register_data'] ?? [];  // empty array if nothing submitted yet
$errors = $errors ?? [];                     // empty array if no validation errors
?>

<div class="reg-layout">

    <!-- =====================================================================
         SIDEBAR — step indicator
         Shows all 3 steps and highlights the current one.
         ===================================================================== -->
    <aside class="reg-sidebar">
        <div class="reg-sidebar__brand">
            <h3 class="reg-sidebar__logo">AlpSave</h3>
            <p class="reg-sidebar__label">Admin Portal</p>
        </div>

        <nav class="reg-steps">
            <h2 class="reg-steps__heading">Registration steps</h2>
            <div class="step-item <?= $step >= 1 ? 'step-item--active' : '' ?>">
                <div class="step-dot"><?= $step > 1 ? '✓' : '1' ?></div>
                <div class="step-meta">
                    <span class="step-meta__title">Account details</span>
                    <span class="step-meta__sub">Name, email &amp; password</span>
                </div>
            </div>

            <div class="step-connector"></div>

            <div class="step-item <?= $step >= 2 ? 'step-item--active' : '' ?>">
                <div class="step-dot"><?= $step > 2 ? '✓' : '2' ?></div>
                <div class="step-meta">
                    <span class="step-meta__title">Role &amp; permissions</span>
                    <span class="step-meta__sub">Set access level</span>
                </div>
            </div>

            <div class="step-connector"></div>

            <div class="step-item <?= $step >= 3 ? 'step-item--active' : '' ?>">
                <div class="step-dot"><?= $step > 3 ? '✓' : '3' ?></div>
                <div class="step-meta">
                    <span class="step-meta__title">Profile &amp; confirm</span>
                    <span class="step-meta__sub">Avatar and terms</span>
                </div>
            </div>
        </nav>

        <span class="reg-sidebar__counter"><?= $step < 4 ? 'Step ' . $step . ' of 3' : 'Complete' ?></span>
    </aside>

    <!-- =====================================================================
         MAIN CONTENT
         ===================================================================== -->
    <main class="reg-content">

        <div class="reg-content__form">
            <h2 class="reg-content__heading">Create your account</h2>
            <p class="reg-content__sub">Fill in your details to request admin access.</p>


            <?php if (!empty($errors)): ?>
                <div class="form-error-banner">Please correct the highlighted fields below.</div>
            <?php endif; ?>

            <!-- ===========================================================
                 Success message
                 =========================================================== -->
            <?php if ($step === 4): ?>

                <div class="form-success">
                    <h3>Registration complete!</h3>
                    <p>Your account request has been submitted. You can now sign in.</p>
                </div>

                <div class="form-nav">
                    <a href="index.php?page=login" class="btn btn--primary">Go to login →</a>

                    <form method="POST" action="index.php?page=register">

                        <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">
                        <button type="submit" name="action" value="restart" class="btn btn--back">Register another
                            account</button>
                    </form>
                </div>

            <?php else: ?>

                <form method="POST" action="index.php?page=register" enctype="multipart/form-data" novalidate>

                    <input type="hidden" name="csrf" value="<?= htmlspecialchars(Csrf::token()) ?>">

                    <input type="hidden" name="step" value="<?= $step ?>">

                    <!-- ===========================================================
                     STEP 1 — Account details
                     =========================================================== -->
                    <?php if ($step === 1): ?>

                        <div class="form-row">

                            <div class="form-group">
                                <label class="form-label" for="username">Username</label>

                                <input class="form-input <?= isset($errors['username']) ? 'form-input--error' : '' ?>"
                                    type="text" id="username" name="username"
                                    value="<?= htmlspecialchars($data['username'] ?? '') ?>" placeholder="e.g. alpsave">
                                <?php if (isset($errors['username'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['username']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email Address</label>
                                <input class="form-input <?= isset($errors['email']) ? 'form-input--error' : '' ?>" type="email"
                                    id="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                                    placeholder="e.g. info@alpsave.ch">
                                <?php if (isset($errors['email'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['email']) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>

                                <input class="form-input <?= isset($errors['password']) ? 'form-input--error' : '' ?>"
                                    type="password" id="password" name="password" placeholder="e.g. Password123!">
                                <?php if (isset($errors['password'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['password']) ?></span>
                                <?php endif; ?>
                                <span class="form-hint">1 uppercase · 1 lowercase · 1 digit · 1 special char</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirm">Confirm Password</label>
                                <input class="form-input <?= isset($errors['password_confirm']) ? 'form-input--error' : '' ?>"
                                    type="password" id="password_confirm" name="password_confirm"
                                    placeholder="e.g. Password123!">
                                <?php if (isset($errors['password_confirm'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['password_confirm']) ?></span>
                                <?php endif; ?>
                            </div>

                        </div>

                        <!-- ===========================================================
                     STEP 2 — Role & permissions
                     =========================================================== -->
                    <?php elseif ($step === 2): ?>

                        <div class="form-group form-group--full">
                            <label class="form-label">Role</label>
                            <div class="role-grid">
                                <?php

                                $roles = [
                                    'super_admin' => ['label' => 'Super Admin', 'sub' => 'Full access to all areas'],
                                    'admin' => ['label' => 'Admin', 'sub' => 'Standard admin access'],
                                    'data_manager' => ['label' => 'Data Manager', 'sub' => 'Upload and manage data'],
                                    'read_only' => ['label' => 'Read Only', 'sub' => 'View data, no edits'],
                                ];

                                foreach ($roles as $value => $role):
                                    $selected = ($data['role'] ?? '') === $value;
                                    ?>

                                    <label class="<?= $selected ? 'role-card role-card--selected' : 'role-card' ?>">
                                        <input type="radio" name="role" value="<?= $value ?>" <?= $selected ? 'checked' : '' ?>>
                                        <span class="role-card__title"><?= htmlspecialchars($role['label']) ?></span>
                                        <span class="role-card__sub"><?= htmlspecialchars($role['sub']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <?php if (isset($errors['role'])): ?>
                                <span class="field-error"><?= htmlspecialchars($errors['role']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group form-group--full">
                            <label class="form-label" for="department">Department</label>
                            <select
                                class="form-input form-select <?= isset($errors['department']) ? 'form-input--error' : '' ?>"
                                id="department" name="department">
                                <option value="">Select your department</option>
                                <option value="finance" <?= ($data['department'] ?? '') === 'finance' ? 'selected' : '' ?>>Finance
                                </option>
                                <option value="engineering" <?= ($data['department'] ?? '') === 'engineering' ? 'selected' : '' ?>>
                                    Engineering</option>
                                <option value="operations" <?= ($data['department'] ?? '') === 'operations' ? 'selected' : '' ?>>
                                    Operations</option>
                                <option value="hr" <?= ($data['department'] ?? '') === 'hr' ? 'selected' : '' ?>>Human Resources
                                </option>
                                <option value="marketing" <?= ($data['department'] ?? '') === 'marketing' ? 'selected' : '' ?>>
                                    Marketing</option>
                            </select>
                            <?php if (isset($errors['department'])): ?>
                                <span class="field-error"><?= htmlspecialchars($errors['department']) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- ===========================================================
                     STEP 3 — Profile & confirm
                     =========================================================== -->
                    <?php elseif ($step === 3): ?>

                        <div class="form-group form-group--full">
                            <label class="form-label">
                                Profile photo <span class="form-label--optional">(optional)</span>
                            </label>
                            <div class="photo-upload">
                                <div class="photo-upload__avatar">

                                    <?= htmlspecialchars(strtoupper(substr($data['username'] ?? 'U', 0, 1))) ?>
                                </div>
                                <div class="photo-upload__actions">
                                    <label class="btn btn--outline" for="photo">Upload photo</label>
                                    <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" class="sr-only">
                                    <p class="form-hint">JPG or PNG, max 2 MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group--full">
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" value="1" <?= !empty($data['terms']) ? 'checked' : '' ?>>
                                    <span>I accept the <a href="#">Terms of Service</a> and <a href="#">Privacy
                                            Policy</a>.</span>
                                </label>
                                <?php if (isset($errors['terms'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['terms']) ?></span>
                                <?php endif; ?>

                                <label class="checkbox-label">
                                    <input type="checkbox" name="notifications" value="1" <?= !empty($data['notifications']) ? 'checked' : '' ?>>
                                    <span>Receive email notifications for critical system events.</span>
                                </label>
                            </div>
                        </div>

                    <?php endif; // end of step conditions ?>

                    <!-- ===========================================================
                     NAVIGATION BUTTONS
                     =========================================================== -->
                    <div class="form-nav <?= $step === 1 ? 'form-nav--single' : '' ?>">

                        <?php if ($step > 1): ?>
                            <button type="submit" name="action" value="back" class="btn btn--back">← Back</button>
                        <?php endif; ?>

                        <?php if ($step < 3): ?>
                            <button type="submit" name="action" value="continue" class="btn btn--primary">Continue →</button>
                        <?php else: ?>
                            <button type="submit" name="action" value="finish" class="btn btn--primary">Finish</button>
                        <?php endif; ?>

                    </div>

                </form>

            <?php endif; // end of step 4 vs steps 1–3 ?>

            <?php if ($step !== 4): ?>
                <p class="login-content__register">Already have an account? <a href="index.php?page=login">Sign in →</a></p>
            <?php endif; ?>
        </div><!-- /.reg-content__form -->
    </main>

</div><!-- /.reg-layout -->