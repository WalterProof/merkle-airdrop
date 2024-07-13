<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var       \App\View\AppView $this
 */

$this->extend('base');
$this->append('title', ' – Tez Drops');
?>

<main class="container">
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Tez Drops</a>
            <ul class="navbar nav">
                <li class="nav-item">
                    <?= $this->Html->link(
                        'Airdrops',
                        ['controller' => 'Airdrops', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ); ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        'Airdrops Recipients',
                        ['controller' => 'AirdropsRecipients', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ); ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        'Tokens',
                        ['controller' => 'Tokens', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ); ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        'Recipients',
                        ['controller' => 'Recipients', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ); ?>
                </li>
                <div x-data="beacon" class="flex items-center md:order-2">
                    <button @click="login('<?= $this->request->getAttribute('csrfToken') ?>')">Sync</button>
                    <span x-show="error" class="text-red-600 font-semibold"><span x-text="error"></span></span>
                </div>
            </ul>
        </div>
    </nav>
    <?php echo $this->Flash->render() ?>
    <?php echo $this->fetch('content') ?>
</main>
