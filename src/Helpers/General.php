<?php


namespace AmoCRM\Helpers;


use AmoCRM\Models\Contact;
use AmoCRM\Models\Lead;

class General
{
    public static function getContactPhone(Contact $contact): ?string
    {
        if ($contact['custom_fields']) {
            foreach ($contact['custom_fields'] as $field) {
                if ($field['code'] == 'PHONE') {
                    return $field['values'][0]['value'];
                }
            }
        }
        return null;
    }

    public static function formatPhone(string $phone): string
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        if (strlen($phone) == 11) {
            $phone = "7" . substr($phone, 1);
        }
        return $phone;
    }

    public static function getContactsIdFromLeads(array $leads): array
    {
        $contactsIds = [];
        foreach ($leads as $lead) {
            $contactsIds[] = $lead['main_contact_id'];
        }
        return $contactsIds;
    }

    public static function getContactOfLead(Lead $lead, array $contacts): ?Contact{
        foreach ($contacts as $contact) {
            if ($lead['main_contact_id'] == $contact['id']) {
                return $contact;
            }
        }
        return null;
    }

    public static function getFieldValue($entity, int $fieldId){
        if(!isset($entity['custom_fields'])) return null;
        foreach ($entity['custom_fields'] as $field) {
            if ($field['id'] == $fieldId){
                return $field['values'][0]['value'];
            }
        }
        return null;
    }

    public static function getEnumValues($entity, int $fieldId){
        if(!isset($entity['custom_fields'])) return null;
        $values = [];
        foreach ($entity['custom_fields'] as $field) {
            if ($field['id'] == $fieldId){
                foreach ($field['values'] as $value){
                    $values[$value['enum']] = $value['value'];
                }
            }
        }
        return null;
    }
}
