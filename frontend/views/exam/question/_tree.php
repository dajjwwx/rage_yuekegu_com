<?php
/* @var $categories array */
/* @var $activeId string */
/* @var $depth int */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<ul class="tree-view">
    <?php foreach ($categories as $node): ?>
        <li>
            <?php 
                $hasChildren = !empty($node['children']);
                $url = Url::current(['category_id' => $node['id'], 'page' => null]);
                $isActive = $activeId == $node['id'];
            ?>
            <?php if ($hasChildren): ?>
                <span class="tree-toggle-icon" onclick="toggleTree(this)">▶</span>
            <?php else: ?>
                <span class="tree-toggle-icon" style="visibility:hidden;">▶</span>
            <?php endif; ?>
            <?= Html::a(Html::encode($node['name']), $url, [
                'class' => $isActive ? 'active' : '',
            ]) ?>
            <?php if ($hasChildren): ?>
                <div class="tree-children" style="display: <?= $isActive ? 'block' : 'none' ?>;">
                    <?= $this->render('_tree', [
                        'categories' => $node['children'],
                        'activeId' => $activeId,
                        'depth' => $depth + 1,
                    ]) ?>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php
$js = <<<JS
function toggleTree(el) {
    var children = el.parentElement.querySelector('.tree-children');
    if (children) {
        if (children.style.display === 'none') {
            children.style.display = 'block';
            el.textContent = '▼';
        } else {
            children.style.display = 'none';
            el.textContent = '▶';
        }
    }
}
// Expand active path
document.querySelectorAll('.tree-view a.active').forEach(function(a) {
    var p = a.parentElement;
    while (p) {
        var children = p.querySelector(':scope > .tree-children');
        if (children) children.style.display = 'block';
        var icon = p.querySelector(':scope > .tree-toggle-icon');
        if (icon && icon.textContent === '▶') icon.textContent = '▼';
        p = p.parentElement.closest('li');
    }
});
JS;
$this->registerJs($js);
?>
