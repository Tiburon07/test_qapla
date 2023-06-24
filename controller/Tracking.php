<?php


class Tracking{
    
    function index(){
        require_once("view/tracking/index.php");
    }

    function getHistory(){

        $tn=$_GET["tracking_number"];

        $result = [];

        $jsonData = json_decode(file_get_contents("https://track.amazon.it/api/tracker/$tn"));
        $eventHistory = $jsonData->eventHistory;

        $arrStr = $this->getLocalizedString();
        foreach ($arrStr as $key => $value )
            $eventHistory = str_replace($key, $value, $eventHistory);

        $arrEvent = json_decode($eventHistory)->eventHistory;

        foreach ($arrEvent as $event) {
            $result[] = [
                    "stato" => $event->statusSummary->localisedStringId,
                    "data" => $event->eventTime,
                    "luogo" => ($event->location->city) ? [
                        "citta" => $event->location->city,
                        "provincia" => $event->location->stateProvince,
                        "codice_stato"=> $event->location->countryCode,
                        "cap"=> $event->location->postalCode,
                    ] : ''
                ];
        }


        header("Content-Type: application/json");
        echo json_encode($result);
        exit();
    }

    function getLocalizedString(){
        return [
            "rx_delivery_instructions_ques_code"=>"Ci serve un codice di sicurezza o un numero di citofono per accedere a questo edificio?",
            "rx_delivery_instructions_ques_code_placeholder"=> "Codice di accesso",
            "rx_delivery_instructions_ques_instructions"=>"Abbiamo bisogno di altre istruzioni per trovare questo indirizzo?",
            "rx_delivery_instructions_ques_instructions_placeholder"=>"Fornisci dettagli come la descrizione dell'edificio, un punto di riferimento nelle vicinanze o altre istruzioni di navigazione",
            "rx_delivery_instructions_ques_neighbor"=>"A quale vicino dovremmo lasciare il pacco?",
            "rx_delivery_instructions_ques_neighbor_house_number_placeholder"=>"numero di casa",
            "rx_delivery_instructions_ques_neighbor_name_placeholder"=>"Nome del vicino",
            "rx_delivery_instructions_ques_neighbor_subtext"=>"La casa del tuo vicino {emphasis}. Per favore, informa il tuo vicino della consegna.",
            "rx_delivery_instructions_ques_neighbor_subtext_emphasis"=>"deve essere accanto",
            "rx_delivery_instructions_ques_where"=>"Dove lasciamo il pacco se non potrai ritirarlo personalmente?",
            "rx_delivery_instructions_ques_where_placeholder"=>"Posizione",
            "rx_delivery_instructions_required_field"=>"Questo è richiesto",
            "rx_delivery_text"=>"consegna",
            "rx_home_text"=>"Domicilio",
            "rx_second_delivery_text"=>"Seconda consegna",
            "rx_spd_label_any_secure_location"=>"Qualsiasi luogo sicuro",
            "rx_spd_label_behind_wheelie_bin"=>"Dietro il cassonetto con le ruote",
            "rx_spd_label_concierge_receptionist"=>"Ricezione",
            "rx_spd_label_enclosed_front_porch"=>"Portico recintato",
            "rx_spd_label_frontdoor"=>"Porta di casa",
            "rx_spd_label_garage"=>"Garage",
            "rx_spd_label_garden"=>"Giardino",
            "rx_spd_label_greenhouse"=>"Serra",
            "rx_spd_label_mailroom_delivery"=>"casella postale",
            "rx_spd_label_neighbor_delivery"=>"Vicino di casa",
            "rx_spd_label_no_special_delivery"=>"Nessuna delle opzioni precedenti",
            "rx_spd_label_propertystaff_mailroom"=>"casella postale",
            "rx_spd_label_rear_door"=>"Porta sul retro",
            "rx_spd_label_rear_porch"=>"Veranda posteriore",
            "rx_spd_label_security_guard"=>" Addetto alla sicurezza",
            "rx_spd_label_shed"=>"Casetta porta attrezzi",
            "rx_spd_label_terrasse_delivery"=>"Terrazza",
            "rx_third_delivery_text"=>"Terza consegna",
            "rx_today_text"=>"oggi",
            "rx_tomorrow_text"=>"domani",
            "swa_rx_address_city_label"=>"Città",
            "swa_rx_address_country_label_eu_it"=>"Paese / Regione",
            "swa_rx_address_district_county_label_eu_it"=>"Contea",
            "swa_rx_address_full_name"=>"Nome e cognome",
            "swa_rx_address_line1_label"=>"Riga indirizzo 1",
            "swa_rx_address_line2_label"=>"Riga indirizzo 2",
            "swa_rx_address_list_new_address"=>"Nuovo indirizzo",
            "swa_rx_address_list_phone_number"=>"Numero di telefono: {phoneNumber}",
            "swa_rx_address_list_update_delivery_instructions"=>"Aggiorna le istruzioni di consegna",
            "swa_rx_address_loading_countries_text"=>"Recupero dei paesi disponibili...",
            "swa_rx_address_note_text"=>"* Può essere utilizzato come ausilio alla consegna",
            "swa_rx_address_page_invalid_phone_message"=>"Numero di telefono non valido",
            "swa_rx_address_page_invalid_postal_message"=>"Codice postale non valido",
            "swa_rx_address_page_required_field_message"=>"Questo campo è obbligatorio",
            "swa_rex_error_404_message"=>"Impossibile trovare la pagina che stai cercando.",
            "swa_rex_error_404_title"=>"Siamo spiacenti",
            "swa_rex_error_500_message"=>"Attendi un momento e riprova.",
            "swa_rex_error_500_title"=>"Si è verificato un problema",
            "swa_rex_error_dog_link_message"=>"Incontra i cani di Amazon",
            "swa_rex_error_dog_title"=>"Waffle",
            "swa_rx_active_address_error"=>"Impossibile recuperare i dettagli dell'indirizzo.",
            "swa_rx_add_address_title"=>"Nuovo indirizzo di consegna",
            "swa_rx_address_book_heading"=>"Gestisci indirizzi",
            "swa_rx_address_book_info_message_eu_it"=>"Per modificare o eliminare i tuoi indirizzi, visita il tuo account su Amazon.it {addressBook}",
            "swa_rx_address_book_loading_error"=>"Non siamo riusciti a caricare i tuoi indirizzi.",
            "swa_rx_address_book_manage_on_amazon"=>"Gestisci su Amazon",
            "swa_rx_address_book_new_address"=>"Nuovo indirizzo",
            "swa_rx_address_book_no_addresses"=>"Non hai ancora indicato nessun indirizzo",
            "swa_rx_address_entered_text"=>"Indirizzo inserito",
            "swa_rx_address_invalid_warning"=>"Non è stato possibile verificare il tuo indirizzo. Controllalo per assicurarti che sia corretto.",
            "swa_rx_address_not_verified"=>"Non è stato possibile verificare l'indirizzo.",
            "swa_rx_address_notification_create_error"=>"Si è verificato un problema durante il salvataggio del nuovo indirizzo. Riprova.",
            "swa_rx_address_notification_create_success"=>"Indirizzo salvato",
            "swa_rx_address_notification_duplicate_error"=>"Questo indirizzo è già stato salvato nella rubrica.",
            "swa_rx_address_notification_update_error"=>"Si è verificato un problema durante il salvataggio del tuo indirizzo. Riprova.",
            "swa_rx_address_notification_update_success"=>"Indirizzo aggiornato",
            "swa_rx_address_sorry_text"=>"Ci dispiace.",
            "swa_rx_address_suggested_text"=>"Indirizzo consigliato",
            "swa_rx_address_suggestion_note"=>"Per garantire la precisione della consegna, vedi le modifiche suggerite a questo indirizzo e scegli la versione che desideri utilizzare.",
            "swa_rx_address_update_retry"=>"Aggiorna il tuo indirizzo per salvarlo.",
            "swa_rx_address_verify_text"=>"Verifica il tuo indirizzo",
            "swa_rx_app_cancel_text"=>"Annulla",
            "swa_rx_app_exit_text"=>"Esci",
            "swa_rx_app_loading_text"=>"Caricamento in corso...",
            "swa_rx_app_refresh"=>"Aggiorna la pagina per riprovare.",
            "swa_rx_app_save_text"=>"Salva",
            "swa_rx_app_sorry"=>"Siamo spiacenti",
            "swa_rx_apply_amazon_account"=>"Nota: applicheremo le istruzioni per il salvataggio di questo indirizzo anche al tuo account Amazon.",
            "swa_rx_contact_us_label"=>"Contattaci",
            "swa_rx_contact_us_link"=>"Contattaci",
            "swa_rx_contact_us_text"=>"Hai ancora bisogno di aiuto? {link}",
            "swa_rx_countries_fetch_error"=>"Impossibile recuperare l'elenco dei paesi. Aggiorna la pagina e riprova.",
            "swa_rx_create_account"=>"Crea account",
            "swa_rx_goto_addressess"=>"Vai agli indirizzi",
            "swa_rx_help_error"=>"Impossibile caricare il contenuto della Guida",
            "swa_rx_help_heading"=>"In che modo possiamo aiutarti?",
            "swa_rx_help_title"=>"Aiuto",
            "swa_rx_home_label"=>"Casa",
            "swa_rx_manage_addresses"=>"Gestisci indirizzi",
            "swa_rx_packages_label"=>"Pacchi",
            "swa_rx_signin"=>"Log in",
            "swa_rx_signout"=>"Esci",
            "swa_rx_sub_address_title"=>"Indirizzo",
            "swa_rx_sub_delivery_prefs_title"=>"Istruzioni di consegna",
            "swa_rx_sub_update_address_title"=>"indirizzo",
            "swa_rx_sub_update_delivery_prefs_title"=>"Istruzioni di consegna",
            "swa_rx_track_title"=>"Traccia",
            "swa_rx_tracking_id_label"=>"Numero di spedizione {trackingId}",
            "swa_rx_tracking_placeholder"=>"inserisci un numero di spedizione",
            "swa_rx_update_delivery_ins_sub_title"=>"Salveremo gli aggiornamenti alle istruzioni di consegna per questo indirizzo per tutte le consegne a questo indirizzate. Salveremo le modifiche anche nella tua rubrica Amazon.",
            "swa_rx_update_delivery_ins_title"=>"Aggiorna le istruzioni di consegna",
            "swa_rx_update_delivery_prefs_not_applicable_tracking"=>"L'aggiornamento delle istruzioni di consegna non sarà valido per il pacco corrente, ma si applicherà ai pacchi futuri.",
            "swa_rx_update_delivery_prefs_not_applicable_tracking_title"=>"Pacco in transito",
            "swa_rx_use_address_text"=>"Usa indirizzo",
            "swa_rx_user_welcome_message_eu_it"=>"Ora puoi utilizzare il nostro sito web per monitorare e gestire tutti i tuoi prossimi ordini di cui Amazon Shipping organizza la consegna",
            "swa_rx_user_welcome_title"=>"Benvenuto, {name}",
            "swa_rx_welcome_title"=>"Benvenuto/a, {name} {icon}",
            "swa_rx_your_packages"=>"I tuoi ordini",
            "swa_rex_arrived_at_sort_center"=>"Il pacco è arrivato presso la sede del corriere",
            "swa_rex_delivering_eddday"=>"Arriverà {expectedDeliveryDate}",
            "swa_rex_detail_creation_confirmed"=>"Etichetta creata",
            "swa_rex_detail_departed"=>"Il pacco ha lasciato la sede del corriere",
            "swa_rex_detail_pickedUp"=>"Pacco ritirato",
            "swa_rex_intransit"=>"In transito",
            "swa_rex_ofd"=>"In consegna",
            "swa_rex_shipping_label_created"=>"Etichetta creata",
            "swa_rex_summary_in_transit"=>"In arrivo "
        ];
    }

}
?>
