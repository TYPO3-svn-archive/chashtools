<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Oliver Hader <oliver@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class to handle common behaviours.
 *
 * @author Oliver Hader <oliver@typo3.org>
 */
class tx_chashtools {
	/**
	 * @var array
	 */
	protected static $configuration;

	/**
	 * @var array
	 */
	protected static $additionalExcludeArguments = array();

	/**
	 * Adds an additional argument to be excluded.
	 *
	 * @param mixed $arguments The arguments to be added (can be comma-separated string or array)
	 * @return void
	 */
	public static function addExcludeArguments($arguments) {
		if (is_string($arguments)) {
			$arguments = t3lib_div::trimExplode(',', $arguments, TRUE);
		} elseif (!is_array($arguments)) {
			$arguments = array();
		}

		self::$additionalExcludeArguments = array_unique(
			array_merge(self::$additionalExcludeArguments, $arguments)
		);
	}

	/**
	 * Gets the arguments to be excluded.
	 *
	 * @return array
	 */
	public static function getExcludeArguments() {
		$excludeArguments = array();

		$configuration = self::getConfiguration();
		if (isset($configuration['excludeArguments'])) {
			$excludeArguments = t3lib_div::trimExplode(',', $configuration['excludeArguments'], TRUE);
		}

		$excludeArguments = array_unique(
			array_merge($excludeArguments, self::$additionalExcludeArguments)
		);

		return $excludeArguments;
	}

	/**
	 * Gets the extension configuration.
	 *
	 * @return array
	 */
	protected static function getConfiguration() {
		if (!isset(self::$configuration)) {
			self::$configuration = array();

			if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['chashtools'])) {
				self::$configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['chashtools']);
			}
		}

		return self::$configuration;
	}
}
