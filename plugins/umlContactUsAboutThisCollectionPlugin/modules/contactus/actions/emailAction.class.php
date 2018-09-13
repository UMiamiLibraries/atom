<?php

class ContactusEmailAction {
	public static function getContactUsEmail( $resource ) {
		$resource_id = $resource->id;

		$sql = '
      select information_object.id, email, information_object_i18n.title, information_object.identifier
from information_object,
     contact_information,
     information_object_i18n
where information_object.id = ' . $resource_id . '
  AND information_object.repository_id = contact_information.actor_id
  AND information_object_i18n.id = information_object.id
    ';

		$ret    = QubitPdo::fetchAll( $sql );
		$result = "";

		if ( is_array( $ret ) ) {
			if ( ! empty( $ret ) ) {
				if ( isset( $ret[0]->email ) ) {
					if ( ! empty( $ret[0]->email ) ) {
						$result = "mailto:" . $ret[0]->email . sprintf( "?subject=Collection %s - %s", $ret[0]->identifier, $ret[0]->title );
					}

				}
			}
		}

		return $result;
	}

}
