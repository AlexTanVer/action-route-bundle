<?php

namespace AlexTanVer\ActionRouteBundle\DTO\Request;

class RequestData
{
    private array $requestData;

    public function __construct(array $requestData = [])
    {
        $this->requestData = $requestData;
    }

    public function set(array $data): void
    {
        $this->requestData = $data;
    }

    public function get(string $fieldName, mixed $defaultValue = null): mixed
    {
        return $this->getFieldValue($fieldName) ?? $defaultValue;
    }

    public function getString(string $fieldName, ?string $defaultValue = null): ?string
    {
        return !is_null($this->getFieldValue($fieldName))
            ? (string)$this->getFieldValue($fieldName)
            : $defaultValue;
    }

    public function getInt(string $fieldName, ?int $defaultValue = null): ?int
    {
        return !is_null($this->getFieldValue($fieldName))
            ? intval($this->getFieldValue($fieldName))
            : $defaultValue;
    }

    public function getFloat(string $fieldName, ?float $defaultValue = null): ?float
    {
        return !is_null($this->getFieldValue($fieldName))
            ? floatval($this->getFieldValue($fieldName))
            : $defaultValue;
    }

    public function getArray(string $fieldName, ?array $defaultValue = []): ?array
    {
        return is_array($this->getFieldValue($fieldName))
            ? $this->getFieldValue($fieldName)
            : $defaultValue;
    }

    public function getBool(string $fieldName, ?bool $defaultValue = null): ?bool
    {
        return !is_null($this->getFieldValue($fieldName))
            ? filter_var(
                $this->getFieldValue($fieldName),
                FILTER_VALIDATE_BOOLEAN
            ) : $defaultValue;
    }


    private function getFieldValue(string $fieldName): mixed
    {
        $fieldPath = explode('.', $fieldName);

        $result = null;
        foreach ($fieldPath as $field) {
            if (!is_null($result)) {
                $result = $result[$field] ?? null;
            } else {
                $result = $this->requestData[$field] ?? null;
            }

            if (is_null($result)) {
                break;
            }
        }

        return $result;
    }

}
