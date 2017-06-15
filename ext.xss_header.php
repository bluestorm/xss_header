<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package     ExpressionEngine
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2003 - 2017, EllisLab, Inc.
 * @license     http://expressionengine.com/user_guide/license.html
 * @link        http://expressionengine.com
 * @since       Version 2.0
 * @filesource
 */

/**
 * XSS Header Extension
 *
 * @package    ExpressionEngine
 * @subpackage Addons
 * @category   Extension
 * @author     Adam Burton
 * @link       http://bluestorm.design
 */
class Xss_header_ext
{
    public $settings       = array();
    public $description    = 'Adds the X-XSS-Protection: 0 header into EE CP requests.';
    public $docs_url       = '';
    public $name           = 'XSS Header';
    public $settings_exist = 'n';
    public $version        = '1.0.0';

    /**
     * Constructor
     *
     * @param   mixed Settings array or empty string if none exist.
     */
    public function __construct($settings = '')
    {
        $this->settings = $settings;
    }

    /**
     * Activate Extension
     *
     * This function enters the extension into the exp_extensions table
     *
     * @see http://codeigniter.com/user_guide/database/index.html for
     * more information on the db class.
     *
     * @return void
     */
    public function activate_extension()
    {
        // Setup custom settings in this array.
        $this->settings = array();

        ee()->db->insert_batch('extensions', array(
            array(
                'class' => __CLASS__,
                'method' => 'sessions_start',
                'hook' => 'sessions_start',
                'settings' => serialize($this->settings),
                'version' => $this->version,
                'enabled' => 'y',
            ),
        ));
    }

    /**
     * sessions_start Hook
     *
     * @param
     * @return
     */
    public function sessions_start()
    {
			if(REQ == 'CP')
			{
				ee()->output->set_header('X-XSS-Protection: 0');
			}
    }

    /**
     * Disable Extension
     *
     * This method removes information from the exp_extensions table
     *
     * @return void
     */
    public function disable_extension()
    {
        ee()->db->delete('extensions', array('class' => __CLASS__));
    }

    /**
     * Update Extension
     *
     * This function performs any necessary db updates when the extension
     * page is visited
     *
     * @return  mixed void on update / false if none
     */
    public function update_extension($current = '')
    {
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }

        ee()->db->update('extensions', array('version' => $this->version), array('class' => __CLASS__));
    }
}

/* End of file ext.xss_header.php */
/* Location: /system/expressionengine/third_party/xss_header/ext.xss_header.php */
