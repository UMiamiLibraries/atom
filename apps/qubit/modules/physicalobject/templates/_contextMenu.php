<section id="physical-objects">

    <h2><?php echo sfConfig::get('app_ui_label_physicalobject') ?></h2>


    <?php foreach ($physicalObjects as $item): ?>
        <div class="field">
            <h3>
                <?php if ($resource != $resource->getCollectionRoot()): ?>
                    <?php if (isset($item->type)): ?>
                        <?php echo $item->type ?>:
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($item->location)): ?>
                    <?php echo render_title($item) ?>
                <?php endif; ?>
            </h3>
            <div>
                <?php if (isset($item->location)): ?>
                    <?php echo $item->getLocation(array('cultureFallback' => 'true')) ?>
                <?php else: ?>
                    <?php echo render_title($item) ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

</section>
