<?php
/*
Plugin Name: TEST plugin.
Version: 0.0.1
Author: shokun
License: GPL2
*/
/*  Copyright 2020 shokun
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License, version 2, as
 *    	published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Dk_Test_Plugin {
	public function __construct() {
		// Activation
		if( function_exists( 'register_activation_hook' ) ) {
			register_activation_hook( __FILE__, array( &$this, 'activation' ) );
		}
		// Deactivation
		if( function_exists( 'register_deactivation_hook ') ) {
			register_deactivation_hook( __FILE__, array( &$this, 'deactivation' ) );
		}
		// Uninstall
		if( function_exists( 'register_uninstall_hook' ) ) {
			register_uninstall_hook( __FILE__, 'PluginDeveloper_Uninstall' );
		}
		// init action
		add_action( 'init', array( $this, 'init_bridge' ) );
		// Thme template
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
	}

	public function activation() {
		// カスタム投稿タイプを作成
		$this->create_post_type();
		// リライトルールをフラッシュ
		flush_rewrite_rules();
	}

	public function deactivation() {
	}

	public function init_bridge() {
		// カスタム投稿タイプを作成
		$this->create_post_type();
	}

	private function create_post_type() {
		$exampleSupports = [
			'title',
			'editor',
			'revisions',
			'page-attributes',
		];
		register_post_type( 'dktest',
			array(
				'label' => 'DkTest',
				'public' => true,
				'has_archive' => false,
				'hierarchical' => true,
				'menu_position' => 20,
				'supports' => $exampleSupports,
				'show_in_rest' => true,
			)
		);
	}

	public static function template_loader( $template ) {
		// テンプレートファイルの場所
		$template_dir = plugin_dir_path( __DIR__ ) . 'dk-test-plugin/templates/';

		if ( is_search() && 'dktest' == $_GET['s'] ) {
			// 探すべきファイル名
			$file_name  = 'search-dktest.php';
		} elseif ( is_singular( 'dktest' ) ) {
			$file_name  = 'single-dktest.php';
		}

		if ( isset( $file_name ) ) {
			// テーマ（子 → 親）のファイルを先に探す
			$theme_file = locate_template( $file_name );
		}

		if ( isset( $theme_file ) && $theme_file ) {
			$template = $theme_file;
		} elseif ( isset( $file_name ) && $file_name ) {
			$template = $template_dir . $file_name;
		}

		return $template;
	}
}

function PluginDeveloper_Uninstall() {
}

$dk_test = new Dk_Test_Plugin();
