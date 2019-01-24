<?php

namespace MichielKempen\LaravelEncryptable;

trait Encryptable
{
	/**
	 * @param $key
	 * @return string
	 */
	public function getAttribute($key)
	{
		$value = parent::getAttribute($key);

		if ($this->isEncryptable($key)) {
			$value = $this->decryptValue($value);
		}

		return $value;
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function setAttribute($key, $value)
	{
		if ($this->isEncryptable($key)) {
			$value = $this->encryptValue($value);
		}

		return parent::setAttribute($key, $value);
	}

	/**
	 * @param $key
	 * @return bool
	 */
	private function isEncryptable($key): bool
	{
		return in_array($key, $this->encryptable);
	}

	/**
	 * @param $value
	 * @return array|mixed
	 */
	private function decryptValue($value)
	{
		if(is_null($value)) {
			return $value;
		}

		if(is_array($value)) {
			return array_map(function ($value) {
				return decrypt($value);
			}, $value);
		}

		return decrypt($value);
	}

	/**
	 * @param $value
	 * @return array|string
	 */
	private function encryptValue($value)
	{
		if(is_null($value)) {
			return $value;
		}

		if(is_array($value)) {
			return array_map(function ($value) {
				return encrypt($value);
			}, $value);
		}

		return encrypt($value);
	}
}