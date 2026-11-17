<?php
/*
 * File:    placeholder.php
 * Module:  Shared
 * Author:  Sarvello team
 * Date:    2026-11-17
 * Purpose: Temporary page shown until a module owner builds the real one.
 */
?>
<h1 class="h3"><?= e($title) ?></h1>
<?php if (!empty($module)): ?>
    <p class="text-muted">This page belongs to <strong><?= e($module) ?></strong> and is being built by <strong><?= e($owner) ?></strong>.</p>
<?php endif; ?>
