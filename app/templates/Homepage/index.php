<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Airdrop[] $recentAirdrops
 * @var array $totalAmounts
 */
?>
<div class="recent-airdrops">
    <h2>Recent Airdrops</h2>
    <?php foreach ($recentAirdrops as $airdrop) : ?>
        <div class="airdrop">
            <h3><?= $airdrop->name ?><h3>
                    <!-- todo: fetch metadata -->
                    <h4><?= $airdrop->token->address ?></h4>
                    <!-- todo: decimal conversion from metadata -->
                    <p><?= $totalAmounts[$airdrop->id] ?> tokens</p>
                    <p><?= $airdrop->description ?></p>
        </div>
        <?php if ($this->Identity->isLoggedIn()) : ?>
            <button>Check Eligibility</button>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
