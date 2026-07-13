<?php

/* @var $categories array */
/* @var $activeId string */
/* @var $depth int */

use yii\helpers\Html;
use yii\helpers\Url;

if (empty($categories)) return;
?>

<?php foreach ($categories as $cat): ?>
    <?php
        $hasChildren = !empty($cat['children']);
        $isActive = $activeId == $cat['id'];
        $url = Url::current(['category_id' => $cat['id'], 'page' => null]);
    ?>
    <div class="tree-item">
        <?php if ($hasChildren): ?>
            <a href="<?= $url ?>" class="tree-item-link <?= $isActive ? 'active' : '' ?>">
                <span class="tree-toggle-icon expanded">▶</span>
                <?= Html::encode($cat['name']) ?>
                <?php if (!empty($cat['count'])): ?>
                    <small class="text-muted">(<?= $cat['count'] ?>)</small>
                <?php endif; ?>
            </a>
            <div class="tree-children">
                <?= $this->render('_tree', ['categories' => $cat['children'], 'activeId' => $activeId, 'depth' => $depth + 1]) ?>
            </div>
        <?php else: ?>
            <a href="<?= $url ?>" class="tree-item-link <?= $isActive ? 'active' : '' ?>" style="padding-left:24px">
                <?= Html::encode($cat['name']) ?>
                <?php if (!empty($cat['count'])): ?>
                    <small class="text-muted">(<?= $cat['count'] ?>)</small>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
