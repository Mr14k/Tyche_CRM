<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Core\Database;
use App\Exceptions\ValidationException;

class ValidationEngine
{
    public static function validate(array $data, array $rules): array
    {
        $errors = [];
        $validatedData = [];

        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            $ruleList = is_array($ruleSet) ? $ruleSet : explode('|', $ruleSet);

            foreach ($ruleList as $rule) {
                list($ruleName, $param) = array_pad(explode(':', $rule, 2), 2, null);

                switch ($ruleName) {
                    case 'required':
                        if ($value === null || trim((string)$value) === '') {
                            $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                        }
                        break;

                    case 'email':
                        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = 'Please enter a valid email address.';
                        }
                        break;

                    case 'min':
                        if ($value && strlen((string)$value) < (int)$param) {
                            $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . " must be at least {$param} characters.";
                        }
                        break;

                    case 'max':
                        if ($value && strlen((string)$value) > (int)$param) {
                            $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . " cannot exceed {$param} characters.";
                        }
                        break;

                    case 'matches':
                        if ($value !== ($data[$param] ?? null)) {
                            $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . " does not match " . str_replace('_', ' ', $param) . '.';
                        }
                        break;

                    case 'unique':
                        // param format: table,column,exceptId
                        if ($value) {
                            list($table, $column, $exceptId) = array_pad(explode(',', $param, 3), 3, null);
                            $column = $column ?: $field;

                            $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :val";
                            $queryParams = ['val' => $value];

                            if ($exceptId) {
                                $sql .= " AND id != :except_id";
                                $queryParams['except_id'] = $exceptId;
                            }

                            $res = Database::fetchOne($sql, $queryParams);
                            if ($res && (int)$res['count'] > 0) {
                                $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is already taken.';
                            }
                        }
                        break;

                    case 'exists':
                        if ($value) {
                            list($table, $column) = array_pad(explode(',', $param, 2), 2, null);
                            $column = $column ?: $field;
                            $res = Database::fetchOne("SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :val", ['val' => $value]);
                            if (!$res || (int)$res['count'] === 0) {
                                $errors[$field][] = 'Selected ' . str_replace('_', ' ', $field) . ' is invalid.';
                            }
                        }
                        break;
                }
            }

            if (!isset($errors[$field])) {
                $validatedData[$field] = is_string($value) ? trim($value) : $value;
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $validatedData;
    }
}
