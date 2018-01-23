<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: Traditional Chinese
 * Translator: Wei Long Ueng (TAIWAN)
 *
 * Last edited:
 * 1st September 2016
 *
 * Package:
 * Stock Manage Advance v3.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 * You also can share your language files by emailing to saleem@tecdiary.com
 * Thank you
 */

/* --------------------- CUSTOM FIELDS ------------------------ */
/*
* Below are custome field labels
* Please only change the part after = and make sure you change the the words in between "";
* $lang['bcf1']                         = "Biller Custom Field 1";
* Don't change this                     = "You can change this part";
* For support email contact@tecdiary.com Thank you!
*/

$lang['bcf1']                           = "公司自訂欄位 1";
$lang['bcf2']                           = "公司自訂欄位 2";
$lang['bcf3']                           = "公司自訂欄位 3";
$lang['bcf4']                           = "公司自訂欄位 4";
$lang['bcf5']                           = "公司自訂欄位 5";
$lang['bcf6']                           = "公司自訂欄位 6";
$lang['pcf1']                           = "產品自訂欄位 1";
$lang['pcf2']                           = "產品自訂欄位 2";
$lang['pcf3']                           = "產品自訂欄位 3";
$lang['pcf4']                           = "產品自訂欄位 4";
$lang['pcf5']                           = "產品自訂欄位 5";
$lang['pcf6']                           = "產品自訂欄位 6";
$lang['ccf1']                           = "顧客自訂欄位 1";
$lang['ccf2']                           = "顧客自訂欄位 2";
$lang['ccf3']                           = "顧客自訂欄位 3";
$lang['ccf4']                           = "顧客自訂欄位 4";
$lang['ccf5']                           = "顧客自訂欄位 5";
$lang['ccf6']                           = "顧客自訂欄位 6";
$lang['scf1']                           = "供應商自訂欄位 1";
$lang['scf2']                           = "供應商自訂欄位 2";
$lang['scf3']                           = "供應商自訂欄位 3";
$lang['scf4']                           = "供應商自訂欄位 4";
$lang['scf5']                           = "供應商自訂欄位 5";
$lang['scf6']                           = "供應商自訂欄位 6";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@tecdiary.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "無資料",
    'sInfo'                         => "顯示第 _START_ 筆到第 _END_ 筆，共 _TOTAL_ 筆資料",
    'sInfoEmpty'                    => "顯示第 0 筆到第 0 筆，共 0 筆資料",
    'sInfoFiltered'                 => "(篩選自 _MAX_ 筆資料)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "顯示 _MENU_ 筆",
    'sLoadingRecords'               => "資料載入中...",
    'sProcessing'                   => "處理中...",
    'sSearch'                       => "搜尋",
    'sZeroRecords'                  => "沒有找到相符的資料",
    'oAria'                                     => array(
      'sSortAscending'                => ": 啟動升冪排序",
      'sSortDescending'               => ": 啟動降冪排序"
      ),
    'oPaginate'                                 => array(
      'sFirst'                        => "<< 第一頁",
      'sLast'                         => "最後頁 >>",
      'sNext'                         => "下一頁 >",
      'sPrevious'                     => "< 上一頁",
      )
    );

/* ----------------- Select2 LANGUAGE ---------------------- */
/*
* Below are select2 lib language entries
* Please only change the part after = and make sure you change the the words in between "";
* 's2_errorLoading'                 => "The results could not be loaded",
* Don't change this                 => "You can change this part but not the word between {} like {t};
* For support email support@tecdiary.com Thank you!
*/

$lang['select2_lang']               = array(
    'formatMatches_s'               => "一個結果可用, 按enter鍵選擇.",
    'formatMatches_p'               => "多筆結果可用, 請使用上下鍵選擇.",
    'formatNoMatches'               => "沒有相符資料",
    'formatInputTooShort'           => "請輸入 {n} 個或更多字元",
    'formatInputTooLong_s'          => "請刪除 {n} 個字元",
    'formatInputTooLong_p'          => "請刪除 {n} 個字元",
    'formatSelectionTooBig_s'       => "你只能選擇 {n} 個品項",
    'formatSelectionTooBig_p'       => "你只能選擇 {n} 個品項",
    'formatLoadMore'                => "載入更多資料...",
    'formatAjaxError'               => "Ajax請求失敗",
    'formatSearching'               => "搜尋中..."
    );


/* ----------------- SMA GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "首頁";
$lang['dashboard']                          = "儀表板";
$lang['username']                           = "使用者名稱";
$lang['password']                           = "密碼";
$lang['first_name']                         = "名";
$lang['last_name']                          = "姓";
$lang['confirm_password']                   = "確認密碼";
$lang['email']                              = "電子郵件";
$lang['phone']                              = "電話";
$lang['company']                            = "公司";
$lang['product_code']                       = "產品碼";
$lang['product_name']                       = "產品名稱";
$lang['cname']                              = "顧客名稱";
$lang['barcode_symbology']                  = "條碼編碼";
$lang['product_unit']                       = "產品單位";
$lang['product_price']                      = "產品售價";
$lang['contact_person']                     = "聯絡人";
$lang['email_address']                      = "電子郵件地址";
$lang['address']                            = "地址";
$lang['city']                               = "城市";
$lang['today']                              = "今日";
$lang['welcome']                            = "歡迎";
$lang['profile']                            = "基本資料";
$lang['change_password']                    = "變更密碼";
$lang['logout']                             = "登出";
$lang['notifications']                      = "通知";
$lang['calendar']                           = "月曆";
$lang['messages']                           = "訊息";
$lang['styles']                             = "風格";
$lang['language']                           = "語言";
$lang['alerts']                             = "警告";
$lang['list_products']                      = "產品列表";
$lang['add_product']                        = "新增產品";
$lang['print_barcodes']                     = "列印條碼";
$lang['print_labels']                       = "列印標籤";
$lang['import_products']                    = "匯入產品";
$lang['update_price']                       = "更新價錢";
$lang['damage_products']                    = "壞品";
$lang['sales']                              = "銷售";
$lang['list_sales']                         = "銷售列表";
$lang['add_sale']                           = "新增銷售";
$lang['deliveries']                         = "交貨";
$lang['gift_cards']                         = "禮品卡";
$lang['quotes']                             = "報價";
$lang['list_quotes']                        = "報價列表";
$lang['add_quote']                          = "新增報價";
$lang['purchases']                          = "採購進貨";
$lang['list_purchases']                     = "採購進貨列表";
$lang['add_purchase']                       = "新增採購進貨";
$lang['add_purchase_by_csv']                = "匯入採購進貨";
$lang['transfers']                          = "調撥";
$lang['list_transfers']                     = "調撥列表";
$lang['add_transfer']                       = "新增調撥";
$lang['add_transfer_by_csv']                = "匯入調撥";
$lang['people']                             = "人員";
$lang['list_users']                         = "使用者列表";
$lang['new_user']                           = "新增使用者";
$lang['list_billers']                       = "公司列表";
$lang['add_biller']                         = "新增公司";
$lang['list_customers']                     = "客戶列表";
$lang['add_customer']                       = "新增客戶";
$lang['list_suppliers']                     = "供應商列表";
$lang['add_supplier']                       = "新增供應商";
$lang['settings']                           = "設定";
$lang['system_settings']                    = "系統設定";
$lang['change_logo']                        = "變更Logo";
$lang['currencies']                         = "貨幣";
$lang['attributes']                         = "產品選項";
$lang['customer_groups']                    = "客戶群組";
$lang['categories']                         = "產品類別";
$lang['subcategories']                      = "子類別";
$lang['tax_rates']                          = "稅率";
$lang['warehouses']                         = "倉庫";
$lang['email_templates']                    = "電子郵件內容模板";
$lang['group_permissions']                  = "使用者群組權限";
$lang['backup_database']                    = "資料庫備份";
$lang['reports']                            = "報告（表）";
$lang['overview_chart']                     = "綜合圖表";
$lang['warehouse_stock']                    = "倉庫庫存圖表";
$lang['product_quantity_alerts']            = "產品庫存警告";
$lang['product_expiry_alerts']              = "產品到期警告";
$lang['products_report']                    = "產品報表";
$lang['daily_sales']                        = "日銷售";
$lang['monthly_sales']                      = "月銷售";
$lang['sales_report']                       = "銷售報表";
$lang['payments_report']                    = "付款報表";
$lang['profit_and_loss']                    = "損益";
$lang['purchases_report']                   = "採購進貨報表";
$lang['customers_report']                   = "客戶報表";
$lang['suppliers_report']                   = "供應商報表";
$lang['staff_report']                       = "員工報表";
$lang['your_ip']                            = "你的IP地址";
$lang['last_login_at']                      = "上次登入時間";
$lang['notification_post_at']               = "通知發佈時間";
$lang['quick_links']                        = "快速連結";
$lang['date']                               = "日期";
$lang['reference_no']                       = "參考號";
$lang['products']                           = "產品";
$lang['customers']                          = "客戶";
$lang['suppliers']                          = "供應商";
$lang['users']                              = "使用者";
$lang['latest_five']                        = "最新5筆";
$lang['total']                              = "總計";
$lang['payment_status']                     = "付款狀態";
$lang['paid']                               = "已付款";
$lang['customer']                           = "客戶";
$lang['status']                             = "狀態";
$lang['amount']                             = "金額";
$lang['supplier']                           = "供應商";
$lang['from']                               = "從";
$lang['to']                                 = "到";
$lang['name']                               = "名稱";
$lang['create_user']                        = "新增使用者";
$lang['gender']                             = "性別";
$lang['biller']                             = "公司";
$lang['select']                             = "選擇";
$lang['warehouse']                          = "倉庫";
$lang['active']                             = "啟動";
$lang['inactive']                           = "不啟動";
$lang['all']                                = "全部";
$lang['list_results']                       = "請使用下表來瀏覽或篩選結果。您也可以下載Excel或PDF文件。";
$lang['actions']                            = "動作";
$lang['pos']                                = "POS";
$lang['access_denied']                      = "無法進入！你沒有權利進入所請求的網頁。如果你認為這是錯誤，請聯繫管理員。";
$lang['add']                                = "新增";
$lang['edit']                               = "編輯";
$lang['delete']                             = "刪除";
$lang['view']                               = "檢視";
$lang['update']                             = "更新";
$lang['save']                               = "儲存";
$lang['login']                              = "登入";
$lang['submit']                             = "送出";
$lang['no']                                 = "No";
$lang['yes']                                = "Yes";
$lang['disable']                            = "關閉";
$lang['enable']                             = "啟用";
$lang['enter_info']                         = "請填寫以下資料。標有*的是必需輸入的資料。";
$lang['update_info']                        = "請更新以下資料。標有*的是必需輸入的資料。";
$lang['no_suggestions']                     = "無法獲取建議的資料，請檢查您的輸入";
$lang['i_m_sure']                           = '是的，我確定。';
$lang['r_u_sure']                           = '您確定?';
$lang['export_to_excel']                    = "匯出至Excel檔";
$lang['export_to_pdf']                      = "匯出至PDF檔";
$lang['image']                              = "圖片";
$lang['sale']                               = "銷售";
$lang['quote']                              = "估價";
$lang['purchase']                           = "採購";
$lang['transfer']                           = "調控";
$lang['payment']                            = "付款";
$lang['payments']                           = "付款";
$lang['orders']                             = "訂單";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "稅號";
$lang['country']                            = "國家";
$lang['add_user']                           = "新增使用者";
$lang['type']                               = "類型";
$lang['person']                             = "人";
$lang['state']                              = "州";
$lang['postal_code']                        = "郵遞區號";
$lang['id']                                 = "ID";
$lang['close']                              = "關閉";
$lang['male']                               = "男";
$lang['female']                             = "女";
$lang['notify_user']                        = "通知使用者";
$lang['notify_user_by_email']               = "以電子郵件通知使用者";
$lang['billers']                            = "公司";
$lang['all_warehouses']                     = "全部倉庫";
$lang['category']                           = "類別";
$lang['product_cost']                       = "產品成本";
$lang['quantity']                           = "數量";
$lang['loading_data_from_server']           = "從伺服器載入資料";
$lang['excel']                              = "Excel";
$lang['print']                              = "列印";
$lang['ajax_error']                         = "Ajax載入錯誤，請重新操作。";
$lang['product_tax']                        = "產品稅";
$lang['order_tax']                          = "訂單稅";
$lang['upload_file']                        = "上傳檔案";
$lang['download_sample_file']               = "下載範例檔案";
$lang['csv1']                               = "請勿變更第一列的欄位名稱及順序.";
$lang['csv2']                               = "正確的欄位順序是";
$lang['csv3']                               = "&amp; 你必須遵照這個規則。<br>請確認CSV檔案是UTF-8編碼，並且不是以位元組順序記號(BOM)作為儲存。";
$lang['import']                             = "匯入";
$lang['note']                               = "註記";
$lang['grand_total']                        = "總計";
$lang['download_pdf']                       = "下載為PDF";
$lang['no_zero_required']                   = "欄位『%s』是必須的";
$lang['no_product_found']                   = "沒有找到產品";
$lang['pending']                            = "待處理";
$lang['sent']                               = "已送";
$lang['completed']                          = "已完成";
$lang['shipping']                           = "運費";
$lang['add_product_to_order']               = "請新增產品到訂單列表";
$lang['order_items']                        = "訂單項目";
$lang['net_unit_cost']                      = "淨單位成本";
$lang['net_unit_price']                     = "淨單價";
$lang['expiry_date']                        = "到期日";
$lang['subtotal']                           = "小計";
$lang['reset']                              = "重置";
$lang['items']                              = "品項";
$lang['au_pr_name_tip']                     = "請開始輸入建議的產品碼或名稱，或者直接掃描條碼。";
$lang['no_match_found']                     = "沒找到! 產品可能缺貨。";
$lang['csv_file']                           = "CSV檔案";
$lang['document']                           = "附件檔案";
$lang['product']                            = "產品";
$lang['user']                               = "使用者";
$lang['created_by']                         = "建立";
$lang['loading_data']                       = "自伺服器載入資料";
$lang['tel']                                = "Tel";
$lang['ref']                                = "參考";
$lang['description']                        = "說明";
$lang['code']                               = "代碼";
$lang['tax']                                = "稅";
$lang['unit_price']                         = "單價";
$lang['discount']                           = "折扣";
$lang['order_discount']                     = "訂單折扣";
$lang['total_amount']                       = "總價";
$lang['download_excel']                     = "下載為Excel";
$lang['subject']                            = "主題";
$lang['cc']                                 = "副本";
$lang['bcc']                                = "密件副本";
$lang['message']                            = "訊息";
$lang['show_bcc']                           = "顯示/隱藏 密件副本";
$lang['price']                              = "價錢";
$lang['add_product_manually']               = "手動新增產品";
$lang['currency']                           = "貨幣";
$lang['product_discount']                   = "產品折扣";
$lang['email_sent']                         = "電子郵件送出成功";
$lang['add_event']                          = "新增事件";
$lang['add_modify_event']                   = "新增/更新事件";
$lang['adding']                             = "加入中...";
$lang['delete']                             = "刪除";
$lang['deleting']                           = "刪除中...";
$lang['calendar_line']                      = "請點擊新增/更新事件的日期.";
$lang['discount_label']                     = "折扣 (5/5%)";
$lang['product_expiry']                     = "產品期限";
$lang['unit']                               = "單位";
$lang['cost']                               = "成本";
$lang['tax_method']                         = "稅率方法";
$lang['inclusive']                          = "包含";
$lang['exclusive']                          = "不包含";
$lang['expiry']                             = "到期";
$lang['customer_group']                     = "客戶群組";
$lang['is_required']                        = "是必須的";
$lang['form_action']                        = "表單動作";
$lang['return_sales']                       = "退貨";
$lang['list_return_sales']                  = "退貨列表";
$lang['no_data_available']                  = "沒有資料";
$lang['disabled_in_demo']                   = "我們很抱歉這個功能在Demo時是關閉的。";
$lang['payment_reference_no']               = "付款參考編號";
$lang['gift_card_no']                       = "禮品卡編號";
$lang['paying_by']                          = "付款方式";
$lang['cash']                               = "現金";
$lang['gift_card']                          = "禮品卡";
$lang['CC']                                 = "信用卡";
$lang['cheque']                             = "支票";
$lang['cc_no']                              = "信用卡號碼";
$lang['cc_holder']                          = "持有者";
$lang['card_type']                          = "卡片類型";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['month']                              = "月";
$lang['year']                               = "年";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "支票號碼";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['send_email']                         = "寄送電子郵件";
$lang['order_by']                           = "下單者：";
$lang['updated_by']                         = "更新者：";
$lang['update_at']                          = "更新日期：";
$lang['error_404']                          = "ERROR 404 頁面找不到 ";
$lang['default_customer_group']             = "預設客戶群組";
$lang['pos_settings']                       = "POS設定";
$lang['pos_sales']                          = "POS銷售";
$lang['seller']                             = "銷售員";
$lang['ip:']                                = "IP:";
$lang['sp_tax']                             = "產品銷售稅";
$lang['pp_tax']                             = "產品採購稅";
$lang['overview_chart_heading']             = "庫存總覽圖包括成本和價格（圓餅圖）與產品稅和訂單稅（列） ，購買（線）和產品的月銷量。您可以保存為JPG，PNG和PDF。";
$lang['stock_value']                        = "產品值";
$lang['stock_value_by_price']               = "產品值（售價）";
$lang['stock_value_by_cost']                = "產品值（成本）";
$lang['sold']                               = "已銷售";
$lang['purchased']                          = "已採購";
$lang['chart_lable_toggle']                 = "您可以點擊圖表圖例更改圖表。點擊上面的圖例來顯示/隱藏圖表。";
$lang['register_report']                    = "收銀機報表";
$lang['sEmptyTable']                        = "表內無資料";
$lang['upcoming_events']                    = "活動預告";
$lang['clear_ls']                           = "清除本機所有資料";
$lang['clear']                              = "清除";
$lang['edit_order_discount']                = "編輯訂單折扣";
$lang['product_variant']                    = "產品選項";
$lang['product_variants']                   = "產品選項";
$lang['prduct_not_found']                   = "產品找不到";
$lang['list_open_registers']                = "列出開啟的收銀機";
$lang['delivery']                           = "交貨";
$lang['serial_no']                          = "序列號";
$lang['logo']                               = "Logo";
$lang['attachment']                         = "附件";
$lang['balance']                            = "結餘";
$lang['nothing_found']                      = "找不到相符的資料";
$lang['db_restored']                        = "資料庫恢復成功。";
$lang['backups']                            = "備份";
$lang['best_seller']                        = "最佳銷售";
$lang['chart']                              = "圖表";
$lang['received']                           = "已接收";
$lang['returned']                           = "已退回";
$lang['award_points']                       = "獎勵積分";
$lang['expenses']                           = "支出";
$lang['add_expense']                        = "新增支出";
$lang['other']                              = "其他";
$lang['none']                               = "無";
$lang['calculator']                         = "計算機";
$lang['updates']                            = "更新";
$lang['update_available']                   = "目前已有新的更新，請立即更新。";
$lang['please_select_customer_warehouse']   = "請選擇顧客/倉庫";
$lang['variants']                           = "資料";
$lang['add_sale_by_csv']                    = "從CSV檔匯入銷售";
$lang['categories_report']                  = "分類報表";
$lang['adjust_quantity']                    = "調整數量";
$lang['quantity_adjustments']               = "數量調整";
$lang['partial']                            = "部分";
$lang['unexpected_value']                   = "發現溢出字元！";
$lang['select_above']                       = "請先選擇上面選項";
$lang['no_user_selected']                   = "沒有選擇使用者，請至少選擇一個使用者。";
$lang['sale_details']                       = "銷售說明";
$lang['due'] 								= "到期";
$lang['ordered'] 							= "已訂購";
$lang['profit'] 						    = "利潤";
$lang['unit_and_net_tip'] 			        = "Calculated on unit (with tax) and net (without tax) i.e <strong>unit(net)</strong> for all sales";
$lang['expiry_alerts'] 				        = "過期警告";
$lang['quantity_alerts'] 				    = "數量警告";
$lang['products_sale']                      = "產品收益";
$lang['products_cost']                      = "產品成本";
$lang['day_profit']                         = "日損益";
$lang['get_day_profit']                     = "你可以點擊日期檢視當日損益。";
$lang['combine_to_pdf']                     = "結合成pdf";
$lang['print_barcode_label']                = "列印條碼/標籤";
$lang['list_gift_cards']                    = "禮品卡列表";
$lang['today_profit']                       = "今天收益";
$lang['adjustments']                        = "調整";
$lang['download_xls']                       = "下載為XLS";
$lang['browse']                             = "瀏覽 ...";
$lang['transferring']                       = "轉移中";
$lang['supplier_part_no']                   = "供應商編號";
$lang['deposit']                            = "預收";
$lang['ppp']                                = "Paypal Pro";
$lang['stripe']                             = "Stripe";
$lang['amount_greater_than_deposit']        = "金額大於客戶預收, 請輸入低於客戶預收的金額。";
$lang['stamp_sign']                         = "簽名蓋章";
$lang['product_option']                     = "產品選項";
$lang['Cheque']                             = "支票";
$lang['sale_reference']                     = "銷售參考";
$lang['surcharges']                         = "附加費";
$lang['please_wait']                        = "請稍待...";
$lang['list_expenses']                      = "支出列表";
$lang['deposit']                            = "預收";
$lang['deposit_amount']                     = "預收金額";
$lang['return_purchases']                   = "採購退回";
$lang['list_return_purchases']              = "採購退回列表";
$lang['expense_categories']                 = "支出費用科目";
$lang['authorize']                          = "Authorize.net";
$lang['expenses_report']                    = "支出報表";
$lang['expense_categories']                 = "支出費用科目";
$lang['edit_event']                         = "編輯事件";
$lang['title']                              = "標題";
$lang['event_error']                        = "標題與開始是必須的";
$lang['start']                              = "開始";
$lang['end']                                = "結束";
$lang['event_added']                        = "事件新增成功";
$lang['event_updated']                      = "事件更新成功";
$lang['event_deleted']                      = "事件刪除成功";
$lang['event_color']                        = "事件顏色";
$lang['toggle_alignment']                   = "畫面左右切換";
$lang['images_location_tip']                = "圖片應上傳至 <strong>uploads</strong> 資料夾.";
$lang['this_sale']                          = "本次銷售";
$lang['return_ref']                         = "退回參考";
$lang['return_total']                       = "全部退回";
$lang['daily_purchases']                    = "日採購";
$lang['monthly_purchases']                  = "月採購";
$lang['reference']                          = "參考";
$lang['no_subcategory']                     = "無子類別";
$lang['returned_items']                     = "已退回品項";
$lang['return_payments']                    = "已退回付款";
$lang['units']                              = "單位";
$lang['price_group']                        = "價錢群組";
$lang['price_groups']                       = "價錢群組";
$lang['no_record_selected']                 = "沒有選擇, 請至少選擇一行項目";
$lang['brand']                              = "品牌";
$lang['brands']                             = "品牌";
$lang['file_x_exist']                       = "系統找不到該檔案，它可能被刪除或移動。";
$lang['status_updated']                     = "狀態已更新成功";
$lang['x_col_required']                     = "前 %d 個欄位是必須的，其餘的是可選的.";
$lang['brands_report']                      = "品牌報表";
$lang['add_adjustment']                     = "新增數量調整";
$lang['best_sellers']                       = "最佳銷售";
$lang['adjustments_report']                 = "數量調整報表";
$lang['stock_counts']                       = "庫存計算";
$lang['count_stock']                        = "計算庫存";
$lang['download']                           = "下載";

$lang['please_select_these_before_adding_product'] = "新增產品前請先選擇這些資料";
