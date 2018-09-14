<section id="action-icons">
  <ul>
  <?php if ( count( $resource->getPhysicalObjects() ) && $resource != $resource->getCollectionRoot() ): ?>
    <div id="request-material">
    <li class="separator"><h4>Request material</h4></li>

    <li>
      <i class="fa fa-cube" style="padding-left: 4px"></i>
      <?php
        $id = explode( ":", $resource->getCollectionRoot()->descriptionIdentifier )[ 1 ];
        $title = $resource->getTitle(array('cultureFallback' => true));
        $creator = $resource->getCreatorsNameString();
        $collectionIdentifier = $resource->getCollectionRoot()->identifier;
        $repositoryCode = substr($collectionIdentifier, 0, 3);
        if ( $repositoryCode === 'ASM' || $repositoryCode == 'ASU' ) { $repositoryCode = 'ASC'; }
        $collectionId = $resource->getCollectionRoot()->referenceCode;
        $collectionTitle = $resource->getCollectionRoot()->title;
        if ( $resource->getDates()[0] == NULL ) {
          $date = 'Unknown';
        } else {
          $date = Qubit::renderDateStartEnd( $resource->getDates()[0]->getDate(array('cultureFallback' => true)), $resource->getDates()[0]->startDate, $resource->getDates()[0]->endDate );
        }
        $location = "";
        foreach ( $resource->getPhysicalObjects() as $item ):
          $location .= " " . $item->getLabel();
        endforeach;
        $repository = $resource->getCollectionRoot()->getRepository();
        $breadcrumb = $resource;
        $i = $resource;
        while( $i->parent != $resource->getCollectionRoot() && $i != $resource->getCollectionRoot() ) {
          if (isset( $i->parent )):
            if ( $i->parent == "" ):
              foreach ( $resource->getPhysicalObjects() as $item ):
                $containers .= " " . $item->getLabel();
              endforeach;
              $breadcrumb = "" . ">" . $breadcrumb;
            else:
              $breadcrumb = $i->parent . ">" . $breadcrumb;
            endif;
          endif;
          $i = $i->parent;
        }
        $location = $breadcrumb . ">" . $location;

        echo "<form name='AeonRequest' target='_blank' method='post' action='https://aeon.library.miami.edu/aeon/aeon.dll' style='display: inline'>";
        echo "<input name='AeonForm' value='EADRequest' type='hidden'>";
        echo "<input name='RequestType' value='Loan' type='hidden'>";
        echo "<input name='DocumentType' value='Manuscript' type='hidden'>";
        echo "<div id=\"{$id}\" style='display: inline'>";
          echo "<input name=\"Request\" type=\"hidden\" value=\"{$id}\">";
          echo "<input value=\"{$collectionTitle}\" name=\"ItemTitle_{$id}\" type=\"hidden\">";
          echo "<input value=\"{$creator}\" name=\"ItemAuthor_{$id}\" type=\"hidden\">";
          echo "<input value=\"{$date}\" name=\"ItemDate_{$id}\" type=\"hidden\">";
          echo "<input value=\"{$location}\" name=\"ItemVolume_{$id}\" type=\"hidden\">";
          echo "<input value=\"{$repository}\" name=\"Location_{$id}\" type=\"hidden\">";
          echo "<input value=\"{$repositoryCode}\" name=\"Site\" type=\"hidden\">";
          echo "<input value=\"{$collectionIdentifier}\" name=\"CallNumber_{$id}\" type=\"hidden\">";
          /* Comment out or remove the UserReview checkbox in production */
          echo "<input id='UserReview' name='UserReview' value='Yes' type='checkbox' style='display:none' checked='checked'>";
        echo "</div>";
        echo "<input name='SubmitButton' value='Submit request' type='submit' style='display: inline; color: #049cdb; outline: none; border: none; background-color: transparent; padding: 0px; font-size: 12px'>";
      echo "</form>";
      ?>
    </li>
    </div>
  <?php endif; ?>

	<li class="separator"><h4><?php echo __('Clipboard') ?></h4></li>

	<li class="clipboard">
		<?php echo get_component('object', 'clipboardButton', array('slug' => $resource->slug, 'wide' => true)) ?>
	</li>

	<li class="separator"><h4><?php echo __('Explore') ?></h4></li>

	<li>
		<a href="<?php echo url_for(array($resource, 'module' => 'informationobject', 'action' => 'reports')) ?>">
			<i class="fa fa-print"></i>
			<?php echo __('Reports') ?>
		</a>
	</li>

	<?php if (InformationObjectInventoryAction::showInventory($resource)): ?>
		<li>
			<a href="<?php echo url_for(array($resource, 'module' => 'informationobject', 'action' => 'inventory')) ?>">
				<i class="fa fa-list-alt"></i>
				<?php echo __('Inventory') ?>
			</a>
		</li>
	<?php endif; ?>

	<li>
		<?php if (isset($resource) && sfConfig::get('app_enable_institutional_scoping') && $sf_user->hasAttribute('search-realm') ): ?>
			<a href="<?php echo url_for(array(
				'module' => 'informationobject',
				'action' => 'browse',
				'collection' => $resource->getCollectionRoot()->id,
				'repos' => $sf_user->getAttribute('search-realm'),
				'topLod' => false)) ?>">
		<?php else: ?>
			<a href="<?php echo url_for(array(
				'module' => 'informationobject',
				'action' => 'browse',
				'collection' => $resource->getCollectionRoot()->id,
				'topLod' => false)) ?>">
		<?php endif; ?>

			<i class="fa fa-list"></i>
			<?php echo __('Browse as list') ?>
		</a>
	</li>

	<li>
		<a href="<?php echo url_for(array(
			'module' => 'informationobject',
			'action' => 'browse',
			'collection' => $resource->getCollectionRoot()->id,
			'topLod' => false,
			'view' => 'card',
			'onlyMedia' => true)) ?>">
			<i class="fa fa-picture-o"></i>
			<?php echo __('Browse digital objects') ?>
		</a>
	</li>

	<?php if ($sf_user->isAdministrator()): ?>
		<li class="separator"><h4><?php echo __('Import') ?></h4></li>
		<li>
			<a href="<?php echo url_for(array($resource, 'module' => 'object', 'action' => 'importSelect', 'type' => 'xml')) ?>">
				<i class="fa fa-download"></i>
				<?php echo __('XML') ?>
			</a>
		</li>
		<li>
			<a href="<?php echo url_for(array($resource, 'module' => 'object', 'action' => 'importSelect', 'type' => 'csv')) ?>">
				<i class="fa fa-download"></i>
				<?php echo __('CSV') ?>
			</a>
		</li>
	<?php endif; ?>

	<li class="separator"><h4><?php echo __('Export') ?></h4></li>

	<?php if ($sf_context->getConfiguration()->isPluginEnabled('sfDcPlugin')): ?>
		<li>
			<a href="<?php echo $resource->urlForDcExport() ?>">
				<i class="fa fa-upload"></i>
				<?php echo __('Dublin Core 1.1 XML') ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if ($sf_context->getConfiguration()->isPluginEnabled('sfEadPlugin')): ?>
		<li>
			<a href="<?php echo $resource->urlForEadExport() ?>">
				<i class="fa fa-upload"></i>
				<?php echo __('EAD 2002 XML') ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if ('sfModsPlugin' == $sf_context->getModuleName() && $sf_context->getConfiguration()->isPluginEnabled('sfModsPlugin')): ?>
		<li>
			<a href="<?php echo url_for(array($resource, 'module' => 'sfModsPlugin', 'sf_format' => 'xml')) ?>">
				<i class="fa fa-upload"></i>
				<?php echo __('MODS 3.5 XML') ?>
			</a>
		</li>
	<?php endif; ?>

	<?php echo get_component('informationobject', 'findingAid', array('resource' => $resource)) ?>

  </ul>
</section>
