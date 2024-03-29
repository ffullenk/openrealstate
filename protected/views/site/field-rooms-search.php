<div class="<?php echo $divClass; ?>">
		<?php
			if (issetModule('selecttoslider') && param('useRoomSlider') == 1) {
				?>
				<span class="search"><div class="<?php echo $textClass; ?>"><?php echo Yii::t('common', 'Rooms range'); ?>:</div> </span>
				<span class="search">
					<?php
					$roomItems = array_merge(
						range(0, param('moduleApartments_maxRooms', 8))
					);
					$roomsMin = isset($this->roomsCountMin) ? CHtml::encode($this->roomsCountMin) : 0;
					$roomsMax = isset($this->roomsCountMax) ? CHtml::encode($this->roomsCountMax) : max($roomItems);

					$selecttoslider = new SelectToSlider;
					$selecttoslider->publishAssets();

					echo '<div class="index-search-form rooms-search-select">';
						echo CHtml::dropDownList('roomsMin', $roomsMin, $roomItems, array('style' => 'display: none;'));
						echo CHtml::dropDownList('roomsMax', $roomsMax, $roomItems, array('style' => 'display: none;'));
						echo '<div class="vals">';
							echo '<div id="roomsMin_selected_val" class="left">'.$roomsMin.'</div>';
							echo '<div id="roomsMax_selected_val" class="right">'.$roomsMax.'</div>';
						echo '</div>';
					echo '</div>';
				echo '</span>';

				Yii::app()->clientScript->registerScript('rooms', '
					$("select#roomsMin, select#roomsMax").selectToUISlider({labels: 2, tooltip: false, tooltipSrc : "text",	labelSrc: "text"});
				', CClientScript::POS_READY);
			}
			else {
				?>
				<span class="search"><div class="<?php echo $textClass; ?>"><?php echo Yii::t('common', 'Number of rooms'); ?>:</div> </span>
				<?php
				$roomItems = array(
					'0' => Yii::t('common', 'Please select'),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => Yii::t('common', '4 and more'),
				);
				echo CHtml::dropDownList('rooms', isset($this->roomsCount) ? CHtml::encode($this->roomsCount) : 0, $roomItems, array('class' => $fieldClass));

				Yii::app()->clientScript->registerScript('rooms', '
					focusSubmit($("select#rooms"));
				', CClientScript::POS_READY);
			}
		?>
</div>