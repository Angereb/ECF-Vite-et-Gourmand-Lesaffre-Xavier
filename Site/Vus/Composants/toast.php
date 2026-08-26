<?php
if (isset($toastMessage) && $toastMessage !== null): ?>
    <div class="toast <?= ($toastType ?? '') === 'erreur' ? 'toast-erreur' : '' ?>" role="status">
        <p class="toast-message"><?= htmlspecialchars($toastMessage) ?></p>
    </div>
<?php endif; ?>