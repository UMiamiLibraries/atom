<div id="sort-header"<?php if ( ! empty( $class ) ): ?> class="<?php echo $class ?>"<?php endif; ?>>
    <div class="sort-options">

        <label><?php echo $sf_data->getRaw( 'label' ) ?>:</label>

        <div class="dropdown">

            <div class="dropdown-selected">
				<?php $options = array(
					'10'  => __( '10' ),
					'20'  => __( '20' ),
					'50'  => __( '50' ),
					'100' => __( '100' )
				) ?>
				<?php $param = $sf_data->getRaw( 'param' ) ?>
				<?php if ( ! empty( $options ) ): ?>
					<?php
					$limit_value = 10;
					if ( isset( $_GET['limit'] ) ) {
						$limit = $_GET['limit'];
						$limit = filter_var( $limit, FILTER_SANITIZE_STRING );

						if ( ctype_digit( $limit ) && intval( $limit ) ) {
							if ( $limit == 10 || $limit == 20 || $limit == 50 || $limit == 100 ) {
								$limit_value = $limit;
							}
						}
					}
					?>
                    <span><?php echo $options[ $limit_value ] ?></span>
					<?php unset( $options[ $limit_value ] ) ?>
				<?php else: ?>
                    <span><?php echo array_shift( $options ) ?></span>
				<?php endif; ?>

            </div>

            <ul class="dropdown-options">

                <span class="pointer"></span>
				<?php foreach ( $options as $key => $value ): ?>
                    <li>
						<?php $urlParams = array(
							                   'module' => $sf_request->module,
							                   'action' => $sf_request->action,
							                   $param   => $value
						                   ) + $sf_data->getRaw( 'sf_request' )->getParameterHolder()->getAll() ?>
                        <a href="<?php echo url_for( $urlParams ) ?>" data-order="<?php echo $key ?>">
                            <span><?php echo $value ?></span>
                        </a>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
