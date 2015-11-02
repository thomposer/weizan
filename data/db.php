<?php
$schemas = 'a:68:{i:0;a:6:{s:9:"tablename";s:11:"ims_account";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:5:{s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"hash";a:6:{s:4:"name";s:4:"hash";s:4:"type";s:7:"varchar";s:6:"length";s:1:"8";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"isconnect";a:7:{s:4:"name";s:9:"isconnect";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:4:"acid";}}s:11:"idx_uniacid";a:3:{s:4:"name";s:11:"idx_uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:1;a:6:{s:9:"tablename";s:19:"ims_account_wechats";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";N;s:6:"fields";a:19:{s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"token";a:6:{s:4:"name";s:5:"token";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"encodingaeskey";a:6:{s:4:"name";s:14:"encodingaeskey";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"access_token";a:7:{s:4:"name";s:12:"access_token";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"level";a:7:{s:4:"name";s:5:"level";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"account";a:6:{s:4:"name";s:7:"account";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"original";a:6:{s:4:"name";s:8:"original";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"signature";a:6:{s:4:"name";s:9:"signature";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"country";a:6:{s:4:"name";s:7:"country";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"province";a:6:{s:4:"name";s:8:"province";s:4:"type";s:7:"varchar";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"city";a:6:{s:4:"name";s:4:"city";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"username";a:6:{s:4:"name";s:8:"username";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"password";a:6:{s:4:"name";s:8:"password";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"lastupdate";a:7:{s:4:"name";s:10:"lastupdate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"key";a:6:{s:4:"name";s:3:"key";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"secret";a:6:{s:4:"name";s:6:"secret";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"styleid";a:7:{s:4:"name";s:7:"styleid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:4:"acid";}}s:7:"idx_key";a:3:{s:4:"name";s:7:"idx_key";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"key";}}}}i:2;a:6:{s:9:"tablename";s:17:"ims_account_yixin";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:13:{s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"token";a:6:{s:4:"name";s:5:"token";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"access_token";a:7:{s:4:"name";s:12:"access_token";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"level";a:7:{s:4:"name";s:5:"level";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"account";a:6:{s:4:"name";s:7:"account";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"signature";a:6:{s:4:"name";s:9:"signature";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"username";a:6:{s:4:"name";s:8:"username";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"password";a:6:{s:4:"name";s:8:"password";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"key";a:6:{s:4:"name";s:3:"key";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"secret";a:6:{s:4:"name";s:6:"secret";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"styleid";a:7:{s:4:"name";s:7:"styleid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:4:"acid";}}s:7:"idx_key";a:3:{s:4:"name";s:7:"idx_key";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"key";}}}}i:3;a:6:{s:9:"tablename";s:19:"ims_activity_coupon";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:16:{s:8:"couponid";a:6:{s:4:"name";s:8:"couponid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"couponsn";a:6:{s:4:"name";s:8:"couponsn";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:6:{s:4:"name";s:11:"description";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:1;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"discount";a:6:{s:4:"name";s:8:"discount";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"condition";a:6:{s:4:"name";s:9:"condition";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"starttime";a:6:{s:4:"name";s:9:"starttime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"endtime";a:6:{s:4:"name";s:7:"endtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"limit";a:7:{s:4:"name";s:5:"limit";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"dosage";a:7:{s:4:"name";s:6:"dosage";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"amount";a:6:{s:4:"name";s:6:"amount";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"thumb";a:6:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"credit";a:6:{s:4:"name";s:6:"credit";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"credittype";a:6:{s:4:"name";s:10:"credittype";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:8:"couponid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:4;a:6:{s:9:"tablename";s:30:"ims_activity_coupon_allocation";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"couponid";a:6:{s:4:"name";s:8:"couponid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"groupid";a:6:{s:4:"name";s:7:"groupid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:3:{i:0;s:7:"uniacid";i:1;s:8:"couponid";i:2;s:7:"groupid";}}}}i:5;a:6:{s:9:"tablename";s:28:"ims_activity_coupon_password";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:7:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"password";a:7:{s:4:"name";s:8:"password";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:6;a:6:{s:9:"tablename";s:26:"ims_activity_coupon_record";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:10:{s:5:"recid";a:6:{s:4:"name";s:5:"recid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:11:"grantmodule";a:7:{s:4:"name";s:11:"grantmodule";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"granttime";a:7:{s:4:"name";s:9:"granttime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"usemodule";a:7:{s:4:"name";s:9:"usemodule";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"usetime";a:7:{s:4:"name";s:7:"usetime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"remark";a:7:{s:4:"name";s:6:"remark";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"couponid";a:6:{s:4:"name";s:8:"couponid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:5:"recid";}}s:8:"couponid";a:3:{s:4:"name";s:8:"couponid";s:4:"type";s:5:"index";s:6:"fields";a:4:{i:0;s:3:"uid";i:1;s:11:"grantmodule";i:2;s:9:"usemodule";i:3;s:6:"status";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:7;a:6:{s:9:"tablename";s:21:"ims_activity_exchange";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:16:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:8:"couponid";a:7:{s:4:"name";s:8:"couponid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:6:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:6:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"extra";a:7:{s:4:"name";s:5:"extra";s:4:"type";s:7:"varchar";s:6:"length";s:4:"3000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"credit";a:6:{s:4:"name";s:6:"credit";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"credittype";a:6:{s:4:"name";s:10:"credittype";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"pretotal";a:6:{s:4:"name";s:8:"pretotal";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"num";a:6:{s:4:"name";s:3:"num";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"total";a:7:{s:4:"name";s:5:"total";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"starttime";a:6:{s:4:"name";s:9:"starttime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"endtime";a:6:{s:4:"name";s:7:"endtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:8;a:6:{s:9:"tablename";s:28:"ims_activity_exchange_trades";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:3:"tid";a:6:{s:4:"name";s:3:"tid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"exid";a:6:{s:4:"name";s:4:"exid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"tid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:3:{i:0;s:7:"uniacid";i:1;s:3:"uid";i:2;s:4:"exid";}}}}i:9;a:6:{s:9:"tablename";s:37:"ims_activity_exchange_trades_shipping";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:13:{s:3:"tid";a:6:{s:4:"name";s:3:"tid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"exid";a:6:{s:4:"name";s:4:"exid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"province";a:6:{s:4:"name";s:8:"province";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"city";a:6:{s:4:"name";s:4:"city";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"district";a:6:{s:4:"name";s:8:"district";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"address";a:6:{s:4:"name";s:7:"address";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"zipcode";a:6:{s:4:"name";s:7:"zipcode";s:4:"type";s:7:"varchar";s:6:"length";s:1:"6";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"mobile";a:6:{s:4:"name";s:6:"mobile";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"tid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:3:"uid";a:3:{s:4:"name";s:3:"uid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"uid";}}}}i:10;a:6:{s:9:"tablename";s:20:"ims_activity_modules";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:3:"mid";a:6:{s:4:"name";s:3:"mid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"exid";a:6:{s:4:"name";s:4:"exid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"available";a:7:{s:4:"name";s:9:"available";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:4:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"mid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:6:"module";a:3:{s:4:"name";s:6:"module";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"module";}}s:3:"uid";a:3:{s:4:"name";s:3:"uid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"uid";}}}}i:11;a:6:{s:9:"tablename";s:27:"ims_activity_modules_record";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"mid";a:6:{s:4:"name";s:3:"mid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"num";a:7:{s:4:"name";s:3:"num";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:3:"mid";a:3:{s:4:"name";s:3:"mid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"mid";}}}}i:12;a:6:{s:9:"tablename";s:17:"ims_article_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"articleid";a:6:{s:4:"name";s:9:"articleid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"isfill";a:7:{s:4:"name";s:6:"isfill";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:13;a:6:{s:9:"tablename";s:15:"ims_basic_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:3:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"rid";a:7:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:14;a:6:{s:9:"tablename";s:12:"ims_business";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:16:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"weid";a:6:{s:4:"name";s:4:"weid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:7:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:7:{s:4:"name";s:7:"content";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"phone";a:7:{s:4:"name";s:5:"phone";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"qq";a:7:{s:4:"name";s:2:"qq";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"province";a:7:{s:4:"name";s:8:"province";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"city";a:7:{s:4:"name";s:4:"city";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"dist";a:7:{s:4:"name";s:4:"dist";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"address";a:7:{s:4:"name";s:7:"address";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"lng";a:7:{s:4:"name";s:3:"lng";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"lat";a:7:{s:4:"name";s:3:"lat";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"industry1";a:7:{s:4:"name";s:9:"industry1";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"industry2";a:7:{s:4:"name";s:9:"industry2";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:11:"idx_lat_lng";a:3:{s:4:"name";s:11:"idx_lat_lng";s:4:"type";s:5:"index";s:6:"fields";a:2:{i:0;s:3:"lng";i:1;s:3:"lat";}}}}i:15;a:6:{s:9:"tablename";s:19:"ims_core_attachment";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:7:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"filename";a:6:{s:4:"name";s:8:"filename";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"attachment";a:6:{s:4:"name";s:10:"attachment";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:16;a:6:{s:9:"tablename";s:14:"ims_core_cache";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";N;s:6:"fields";a:2:{s:3:"key";a:6:{s:4:"name";s:3:"key";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"value";a:6:{s:4:"name";s:5:"value";s:4:"type";s:10:"mediumtext";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"key";}}}}i:17;a:6:{s:9:"tablename";s:15:"ims_core_paylog";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:9:{s:4:"plid";a:6:{s:4:"name";s:4:"plid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"openid";a:7:{s:4:"name";s:6:"openid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"40";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"tid";a:6:{s:4:"name";s:3:"tid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"64";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"fee";a:6:{s:4:"name";s:3:"fee";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"tag";a:7:{s:4:"name";s:3:"tag";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:4:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:4:"plid";}}s:10:"idx_openid";a:3:{s:4:"name";s:10:"idx_openid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"openid";}}s:7:"idx_tid";a:3:{s:4:"name";s:7:"idx_tid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"tid";}}s:11:"idx_uniacid";a:3:{s:4:"name";s:11:"idx_uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:18;a:6:{s:9:"tablename";s:20:"ims_core_performance";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"runtime";a:6:{s:4:"name";s:7:"runtime";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"runurl";a:6:{s:4:"name";s:6:"runurl";s:4:"type";s:7:"varchar";s:6:"length";s:3:"512";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"runsql";a:6:{s:4:"name";s:6:"runsql";s:4:"type";s:7:"varchar";s:6:"length";s:3:"512";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:19;a:6:{s:9:"tablename";s:14:"ims_core_queue";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:9:{s:3:"qid";a:6:{s:4:"name";s:3:"qid";s:4:"type";s:6:"bigint";s:6:"length";s:2:"20";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"message";a:7:{s:4:"name";s:7:"message";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"params";a:7:{s:4:"name";s:6:"params";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"keyword";a:7:{s:4:"name";s:7:"keyword";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"response";a:7:{s:4:"name";s:8:"response";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"dateline";a:6:{s:4:"name";s:8:"dateline";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"qid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:2:{i:0;s:7:"uniacid";i:1;s:4:"acid";}}}}i:20;a:6:{s:9:"tablename";s:17:"ims_core_resource";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:3:"mid";a:6:{s:4:"name";s:3:"mid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"media_id";a:6:{s:4:"name";s:8:"media_id";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"trunk";a:7:{s:4:"name";s:5:"trunk";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"dateline";a:6:{s:4:"name";s:8:"dateline";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"mid";}}s:4:"acid";a:3:{s:4:"name";s:4:"acid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:4:"type";a:3:{s:4:"name";s:4:"type";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:4:"type";}}}}i:21;a:6:{s:9:"tablename";s:17:"ims_core_sessions";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";N;s:6:"fields";a:5:{s:3:"sid";a:7:{s:4:"name";s:3:"sid";s:4:"type";s:4:"char";s:6:"length";s:2:"32";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"openid";a:6:{s:4:"name";s:6:"openid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"data";a:6:{s:4:"name";s:4:"data";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"expiretime";a:7:{s:4:"name";s:10:"expiretime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"sid";}}}}i:22;a:6:{s:9:"tablename";s:17:"ims_core_settings";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";N;s:6:"fields";a:2:{s:3:"key";a:6:{s:4:"name";s:3:"key";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"value";a:6:{s:4:"name";s:5:"value";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"key";}}}}i:23;a:6:{s:9:"tablename";s:15:"ims_cover_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"3";s:6:"fields";a:10:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"multiid";a:7:{s:4:"name";s:7:"multiid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"do";a:7:{s:4:"name";s:2:"do";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:7:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:7:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:24;a:6:{s:9:"tablename";s:11:"ims_mc_card";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:11:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"color";a:7:{s:4:"name";s:5:"color";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"background";a:7:{s:4:"name";s:10:"background";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"logo";a:7:{s:4:"name";s:4:"logo";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"format";a:7:{s:4:"name";s:6:"format";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"fields";a:7:{s:4:"name";s:6:"fields";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"snpos";a:7:{s:4:"name";s:5:"snpos";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"business";a:6:{s:4:"name";s:8:"business";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:25;a:6:{s:9:"tablename";s:19:"ims_mc_card_members";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:7:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:1;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"cid";a:7:{s:4:"name";s:3:"cid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"cardsn";a:7:{s:4:"name";s:6:"cardsn";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:6:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:26;a:6:{s:9:"tablename";s:23:"ims_mc_credits_recharge";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:8:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"tid";a:6:{s:4:"name";s:3:"tid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"transid";a:6:{s:4:"name";s:7:"transid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"fee";a:6:{s:4:"name";s:3:"fee";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:15:"idx_uniacid_uid";a:3:{s:4:"name";s:15:"idx_uniacid_uid";s:4:"type";s:5:"index";s:6:"fields";a:2:{i:0;s:7:"uniacid";i:1;s:3:"uid";}}s:7:"idx_tid";a:3:{s:4:"name";s:7:"idx_tid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"tid";}}}}i:27;a:6:{s:9:"tablename";s:21:"ims_mc_credits_record";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:8:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"credittype";a:7:{s:4:"name";s:10:"credittype";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"num";a:7:{s:4:"name";s:3:"num";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"operator";a:6:{s:4:"name";s:8:"operator";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"remark";a:7:{s:4:"name";s:6:"remark";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:3:"uid";a:3:{s:4:"name";s:3:"uid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"uid";}}}}i:28;a:6:{s:9:"tablename";s:13:"ims_mc_groups";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:5:{s:7:"groupid";a:6:{s:4:"name";s:7:"groupid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"orderlist";a:7:{s:4:"name";s:9:"orderlist";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"isdefault";a:7:{s:4:"name";s:9:"isdefault";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:7:"groupid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:29;a:6:{s:9:"tablename";s:14:"ims_mc_handsel";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:9:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"touid";a:6:{s:4:"name";s:5:"touid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"fromuid";a:6:{s:4:"name";s:7:"fromuid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"sign";a:6:{s:4:"name";s:4:"sign";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"action";a:6:{s:4:"name";s:6:"action";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"credit_value";a:6:{s:4:"name";s:12:"credit_value";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:3:"uid";a:3:{s:4:"name";s:3:"uid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:5:"touid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:30;a:6:{s:9:"tablename";s:19:"ims_mc_mapping_fans";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:10:{s:5:"fanid";a:6:{s:4:"name";s:5:"fanid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:7:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"openid";a:6:{s:4:"name";s:6:"openid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"salt";a:7:{s:4:"name";s:4:"salt";s:4:"type";s:4:"char";s:6:"length";s:1:"8";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"follow";a:7:{s:4:"name";s:6:"follow";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"followtime";a:6:{s:4:"name";s:10:"followtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:12:"unfollowtime";a:6:{s:4:"name";s:12:"unfollowtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"tag";a:7:{s:4:"name";s:3:"tag";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:4:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:5:"fanid";}}s:4:"acid";a:3:{s:4:"name";s:4:"acid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:4:"acid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:6:"openid";a:3:{s:4:"name";s:6:"openid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"openid";}}}}i:31;a:6:{s:9:"tablename";s:22:"ims_mc_mapping_ucenter";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"centeruid";a:6:{s:4:"name";s:9:"centeruid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:32;a:6:{s:9:"tablename";s:14:"ims_mc_members";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:51:{s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"mobile";a:7:{s:4:"name";s:6:"mobile";s:4:"type";s:7:"varchar";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"email";a:7:{s:4:"name";s:5:"email";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"password";a:7:{s:4:"name";s:8:"password";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"salt";a:7:{s:4:"name";s:4:"salt";s:4:"type";s:7:"varchar";s:6:"length";s:1:"8";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"groupid";a:7:{s:4:"name";s:7:"groupid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"credit1";a:7:{s:4:"name";s:7:"credit1";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:7:"default";s:4:"0.00";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"credit2";a:7:{s:4:"name";s:7:"credit2";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:7:"default";s:4:"0.00";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"credit3";a:7:{s:4:"name";s:7:"credit3";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:7:"default";s:4:"0.00";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"credit4";a:7:{s:4:"name";s:7:"credit4";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:7:"default";s:4:"0.00";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"credit5";a:7:{s:4:"name";s:7:"credit5";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:7:"default";s:4:"0.00";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"realname";a:7:{s:4:"name";s:8:"realname";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"nickname";a:7:{s:4:"name";s:8:"nickname";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"avatar";a:7:{s:4:"name";s:6:"avatar";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"qq";a:7:{s:4:"name";s:2:"qq";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"vip";a:7:{s:4:"name";s:3:"vip";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"gender";a:7:{s:4:"name";s:6:"gender";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"birthyear";a:7:{s:4:"name";s:9:"birthyear";s:4:"type";s:8:"smallint";s:6:"length";s:1:"6";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"birthmonth";a:7:{s:4:"name";s:10:"birthmonth";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"birthday";a:7:{s:4:"name";s:8:"birthday";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:13:"constellation";a:7:{s:4:"name";s:13:"constellation";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"zodiac";a:7:{s:4:"name";s:6:"zodiac";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"telephone";a:7:{s:4:"name";s:9:"telephone";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"idcard";a:7:{s:4:"name";s:6:"idcard";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"studentid";a:7:{s:4:"name";s:9:"studentid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"grade";a:7:{s:4:"name";s:5:"grade";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"address";a:7:{s:4:"name";s:7:"address";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"zipcode";a:7:{s:4:"name";s:7:"zipcode";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"nationality";a:7:{s:4:"name";s:11:"nationality";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"resideprovince";a:7:{s:4:"name";s:14:"resideprovince";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"residecity";a:7:{s:4:"name";s:10:"residecity";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"residedist";a:7:{s:4:"name";s:10:"residedist";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"graduateschool";a:7:{s:4:"name";s:14:"graduateschool";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"company";a:7:{s:4:"name";s:7:"company";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"education";a:7:{s:4:"name";s:9:"education";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"occupation";a:7:{s:4:"name";s:10:"occupation";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"position";a:7:{s:4:"name";s:8:"position";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"revenue";a:7:{s:4:"name";s:7:"revenue";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:15:"affectivestatus";a:7:{s:4:"name";s:15:"affectivestatus";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"lookingfor";a:7:{s:4:"name";s:10:"lookingfor";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"bloodtype";a:7:{s:4:"name";s:9:"bloodtype";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"height";a:7:{s:4:"name";s:6:"height";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"weight";a:7:{s:4:"name";s:6:"weight";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"alipay";a:7:{s:4:"name";s:6:"alipay";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"msn";a:7:{s:4:"name";s:3:"msn";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"taobao";a:7:{s:4:"name";s:6:"taobao";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"site";a:7:{s:4:"name";s:4:"site";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"bio";a:6:{s:4:"name";s:3:"bio";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"interest";a:6:{s:4:"name";s:8:"interest";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"uid";}}s:7:"groupid";a:3:{s:4:"name";s:7:"groupid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"groupid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:33;a:6:{s:9:"tablename";s:14:"ims_menu_event";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:5:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"keyword";a:6:{s:4:"name";s:7:"keyword";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:6:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"picmd5";a:6:{s:4:"name";s:6:"picmd5";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:6:"picmd5";a:3:{s:4:"name";s:6:"picmd5";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"picmd5";}}}}i:34;a:6:{s:9:"tablename";s:16:"ims_mobilenumber";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"enabled";a:7:{s:4:"name";s:7:"enabled";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"dateline";a:7:{s:4:"name";s:8:"dateline";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:1;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:35;a:6:{s:9:"tablename";s:11:"ims_modules";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"6";s:6:"fields";a:16:{s:3:"mid";a:6:{s:4:"name";s:3:"mid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"version";a:7:{s:4:"name";s:7:"version";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"ability";a:6:{s:4:"name";s:7:"ability";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:6:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"author";a:6:{s:4:"name";s:6:"author";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:6:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"settings";a:7:{s:4:"name";s:8:"settings";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"subscribes";a:7:{s:4:"name";s:10:"subscribes";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"handles";a:7:{s:4:"name";s:7:"handles";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"isrulefields";a:7:{s:4:"name";s:12:"isrulefields";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"issystem";a:7:{s:4:"name";s:8:"issystem";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"issolution";a:7:{s:4:"name";s:10:"issolution";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"target";a:7:{s:4:"name";s:6:"target";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"mid";}}s:8:"idx_name";a:3:{s:4:"name";s:8:"idx_name";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:4:"name";}}}}i:36;a:6:{s:9:"tablename";s:20:"ims_modules_bindings";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:8:{s:3:"eid";a:6:{s:4:"name";s:3:"eid";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:1;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"entry";a:7:{s:4:"name";s:5:"entry";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"call";a:7:{s:4:"name";s:4:"call";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"do";a:6:{s:4:"name";s:2:"do";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"state";a:6:{s:4:"name";s:5:"state";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"direct";a:7:{s:4:"name";s:6:"direct";s:4:"type";s:3:"int";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"eid";}}s:10:"idx_module";a:3:{s:4:"name";s:10:"idx_module";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"module";}}}}i:37;a:6:{s:9:"tablename";s:15:"ims_music_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:7:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"hqurl";a:7:{s:4:"name";s:5:"hqurl";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:38;a:6:{s:9:"tablename";s:14:"ims_news_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:10:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"parentid";a:7:{s:4:"name";s:8:"parentid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:6:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:6:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:2:"60";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:6:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:6:{s:4:"name";s:12:"displayorder";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"incontent";a:7:{s:4:"name";s:9:"incontent";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:39;a:6:{s:9:"tablename";s:18:"ims_profile_fields";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:2:"37";s:6:"fields";a:9:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:5:"field";a:6:{s:4:"name";s:5:"field";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"available";a:7:{s:4:"name";s:9:"available";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:6:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:8:"smallint";s:6:"length";s:1:"6";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"required";a:7:{s:4:"name";s:8:"required";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"unchangeable";a:7:{s:4:"name";s:12:"unchangeable";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"showinregister";a:7:{s:4:"name";s:14:"showinregister";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:40;a:6:{s:9:"tablename";s:10:"ims_qrcode";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:12:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"acid";a:7:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"qrcid";a:7:{s:4:"name";s:5:"qrcid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:7:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"keyword";a:6:{s:4:"name";s:7:"keyword";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"model";a:7:{s:4:"name";s:5:"model";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"ticket";a:7:{s:4:"name";s:6:"ticket";s:4:"type";s:7:"varchar";s:6:"length";s:3:"250";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"expire";a:7:{s:4:"name";s:6:"expire";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"subnum";a:7:{s:4:"name";s:6:"subnum";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:9:"idx_qrcid";a:3:{s:4:"name";s:9:"idx_qrcid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:5:"qrcid";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:41;a:6:{s:9:"tablename";s:15:"ims_qrcode_stat";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:9:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"acid";a:6:{s:4:"name";s:4:"acid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"qid";a:6:{s:4:"name";s:3:"qid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"openid";a:7:{s:4:"name";s:6:"openid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"qrcid";a:7:{s:4:"name";s:5:"qrcid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:7:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:42;a:6:{s:9:"tablename";s:8:"ims_rule";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"9";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:7:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:43;a:6:{s:9:"tablename";s:16:"ims_rule_keyword";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:2:"13";s:6:"fields";a:8:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"rid";a:7:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:11:"idx_content";a:3:{s:4:"name";s:11:"idx_content";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"content";}}}}i:44;a:6:{s:9:"tablename";s:16:"ims_site_article";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:20:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"kid";a:6:{s:4:"name";s:3:"kid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"iscommend";a:7:{s:4:"name";s:9:"iscommend";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"ishot";a:7:{s:4:"name";s:5:"ishot";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"pcate";a:7:{s:4:"name";s:5:"pcate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"ccate";a:7:{s:4:"name";s:5:"ccate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"template";a:7:{s:4:"name";s:8:"template";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:10:"mediumtext";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:7:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"source";a:7:{s:4:"name";s:6:"source";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"author";a:6:{s:4:"name";s:6:"author";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"linkurl";a:7:{s:4:"name";s:7:"linkurl";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"credit";a:7:{s:4:"name";s:6:"credit";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:13:"idx_iscommend";a:3:{s:4:"name";s:13:"idx_iscommend";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:9:"iscommend";}}s:9:"idx_ishot";a:3:{s:4:"name";s:9:"idx_ishot";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:5:"ishot";}}}}i:45;a:6:{s:9:"tablename";s:17:"ims_site_category";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:16:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"nid";a:7:{s:4:"name";s:3:"nid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"parentid";a:7:{s:4:"name";s:8:"parentid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"enabled";a:7:{s:4:"name";s:7:"enabled";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"icon";a:7:{s:4:"name";s:4:"icon";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"template";a:7:{s:4:"name";s:8:"template";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"styleid";a:6:{s:4:"name";s:7:"styleid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:12:"templatefile";a:7:{s:4:"name";s:12:"templatefile";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"linkurl";a:7:{s:4:"name";s:7:"linkurl";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"ishomepage";a:7:{s:4:"name";s:10:"ishomepage";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"icontype";a:6:{s:4:"name";s:8:"icontype";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"css";a:6:{s:4:"name";s:3:"css";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:46;a:6:{s:9:"tablename";s:14:"ims_site_multi";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:7:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"styleid";a:6:{s:4:"name";s:7:"styleid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"site_info";a:6:{s:4:"name";s:9:"site_info";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"quickmenu";a:6:{s:4:"name";s:9:"quickmenu";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:47;a:6:{s:9:"tablename";s:12:"ims_site_nav";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:13:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"multiid";a:6:{s:4:"name";s:7:"multiid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"section";a:7:{s:4:"name";s:7:"section";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:6:{s:4:"name";s:12:"displayorder";s:4:"type";s:8:"smallint";s:6:"length";s:1:"5";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"position";a:7:{s:4:"name";s:8:"position";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:7:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"icon";a:7:{s:4:"name";s:4:"icon";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"css";a:7:{s:4:"name";s:3:"css";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"1";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:7:"multiid";a:3:{s:4:"name";s:7:"multiid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"multiid";}}}}i:48;a:6:{s:9:"tablename";s:14:"ims_site_slide";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:7:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"thumb";a:7:{s:4:"name";s:5:"thumb";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"displayorder";a:7:{s:4:"name";s:12:"displayorder";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:49;a:6:{s:9:"tablename";s:15:"ims_site_styles";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"templateid";a:6:{s:4:"name";s:10:"templateid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:50;a:6:{s:9:"tablename";s:20:"ims_site_styles_vars";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"templateid";a:6:{s:4:"name";s:10:"templateid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:7:"styleid";a:6:{s:4:"name";s:7:"styleid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"variable";a:6:{s:4:"name";s:8:"variable";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:51;a:6:{s:9:"tablename";s:18:"ims_site_templates";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:8:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"name";a:7:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:6:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"author";a:6:{s:4:"name";s:6:"author";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"url";a:7:{s:4:"name";s:3:"url";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"sections";a:6:{s:4:"name";s:8:"sections";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:52;a:6:{s:9:"tablename";s:16:"ims_solution_acl";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:8:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"title";a:7:{s:4:"name";s:5:"title";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"eid";a:7:{s:4:"name";s:3:"eid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:2:"do";a:6:{s:4:"name";s:2:"do";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"state";a:6:{s:4:"name";s:5:"state";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"enable";a:7:{s:4:"name";s:6:"enable";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:3:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:10:"idx_module";a:3:{s:4:"name";s:10:"idx_module";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"module";}}s:7:"idx_eid";a:3:{s:4:"name";s:7:"idx_eid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"eid";}}}}i:53;a:6:{s:9:"tablename";s:16:"ims_stat_keyword";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:7:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"kid";a:6:{s:4:"name";s:3:"kid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"hit";a:6:{s:4:"name";s:3:"hit";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"lastupdate";a:6:{s:4:"name";s:10:"lastupdate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:14:"idx_createtime";a:3:{s:4:"name";s:14:"idx_createtime";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:10:"createtime";}}}}i:54;a:6:{s:9:"tablename";s:20:"ims_stat_msg_history";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:9:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"kid";a:6:{s:4:"name";s:3:"kid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"from_user";a:6:{s:4:"name";s:9:"from_user";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"module";a:6:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"message";a:6:{s:4:"name";s:7:"message";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:14:"idx_createtime";a:3:{s:4:"name";s:14:"idx_createtime";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:10:"createtime";}}}}i:55;a:6:{s:9:"tablename";s:13:"ims_stat_rule";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"hit";a:6:{s:4:"name";s:3:"hit";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"lastupdate";a:6:{s:4:"name";s:10:"lastupdate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:14:"idx_createtime";a:3:{s:4:"name";s:14:"idx_createtime";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:10:"createtime";}}}}i:56;a:6:{s:9:"tablename";s:15:"ims_uni_account";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:4:{s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"groupid";a:7:{s:4:"name";s:7:"groupid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:57;a:6:{s:9:"tablename";s:23:"ims_uni_account_modules";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"6";s:6:"fields";a:5:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"module";a:7:{s:4:"name";s:6:"module";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"enabled";a:6:{s:4:"name";s:7:"enabled";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"settings";a:6:{s:4:"name";s:8:"settings";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:10:"idx_module";a:3:{s:4:"name";s:10:"idx_module";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:6:"module";}}}}i:58;a:6:{s:9:"tablename";s:21:"ims_uni_account_users";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"role";a:6:{s:4:"name";s:4:"role";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:12:"idx_memberid";a:3:{s:4:"name";s:12:"idx_memberid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"uid";}}}}i:59;a:6:{s:9:"tablename";s:13:"ims_uni_group";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"modules";a:7:{s:4:"name";s:7:"modules";s:4:"type";s:7:"varchar";s:6:"length";s:4:"5000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"templates";a:7:{s:4:"name";s:9:"templates";s:4:"type";s:7:"varchar";s:6:"length";s:4:"5000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:60;a:6:{s:9:"tablename";s:16:"ims_uni_settings";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";N;s:6:"fields";a:18:{s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"passport";a:7:{s:4:"name";s:8:"passport";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"oauth";a:7:{s:4:"name";s:5:"oauth";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"uc";a:6:{s:4:"name";s:2:"uc";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"notify";a:7:{s:4:"name";s:6:"notify";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"creditnames";a:7:{s:4:"name";s:11:"creditnames";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:15:"creditbehaviors";a:7:{s:4:"name";s:15:"creditbehaviors";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"welcome";a:7:{s:4:"name";s:7:"welcome";s:4:"type";s:7:"varchar";s:6:"length";s:2:"60";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"default";a:7:{s:4:"name";s:7:"default";s:4:"type";s:7:"varchar";s:6:"length";s:2:"60";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:15:"default_message";a:7:{s:4:"name";s:15:"default_message";s:4:"type";s:7:"varchar";s:6:"length";s:4:"1000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"shortcuts";a:7:{s:4:"name";s:9:"shortcuts";s:4:"type";s:7:"varchar";s:6:"length";s:4:"5000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"payment";a:7:{s:4:"name";s:7:"payment";s:4:"type";s:7:"varchar";s:6:"length";s:4:"2000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"groupdata";a:6:{s:4:"name";s:9:"groupdata";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"stat";a:6:{s:4:"name";s:4:"stat";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"bootstrap";a:6:{s:4:"name";s:9:"bootstrap";s:4:"type";s:7:"varchar";s:6:"length";s:3:"120";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"menuset";a:6:{s:4:"name";s:7:"menuset";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"default_site";a:7:{s:4:"name";s:12:"default_site";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:1;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:4:"sync";a:6:{s:4:"name";s:4:"sync";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}i:61;a:6:{s:9:"tablename";s:18:"ims_uni_verifycode";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:6:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"uniacid";a:6:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"receiver";a:6:{s:4:"name";s:8:"receiver";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"verifycode";a:6:{s:4:"name";s:10:"verifycode";s:4:"type";s:7:"varchar";s:6:"length";s:1:"6";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"total";a:6:{s:4:"name";s:5:"total";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:62;a:6:{s:9:"tablename";s:17:"ims_userapi_cache";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:4:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"key";a:6:{s:4:"name";s:3:"key";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"content";a:6:{s:4:"name";s:7:"content";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"lastupdate";a:6:{s:4:"name";s:10:"lastupdate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:63;a:6:{s:9:"tablename";s:17:"ims_userapi_reply";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"7";s:6:"fields";a:7:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"rid";a:6:{s:4:"name";s:3:"rid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:11:"description";a:7:{s:4:"name";s:11:"description";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"apiurl";a:7:{s:4:"name";s:6:"apiurl";s:4:"type";s:7:"varchar";s:6:"length";s:3:"300";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"token";a:7:{s:4:"name";s:5:"token";s:4:"type";s:7:"varchar";s:6:"length";s:2:"32";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:12:"default_text";a:7:{s:4:"name";s:12:"default_text";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"cachetime";a:7:{s:4:"name";s:9:"cachetime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:64;a:6:{s:9:"tablename";s:9:"ims_users";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"2";s:6:"fields";a:11:{s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:7:"groupid";a:7:{s:4:"name";s:7:"groupid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"username";a:6:{s:4:"name";s:8:"username";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"password";a:6:{s:4:"name";s:8:"password";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"salt";a:6:{s:4:"name";s:4:"salt";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"4";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"joindate";a:7:{s:4:"name";s:8:"joindate";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"joinip";a:7:{s:4:"name";s:6:"joinip";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"lastvisit";a:7:{s:4:"name";s:9:"lastvisit";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"lastip";a:7:{s:4:"name";s:6:"lastip";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"remark";a:7:{s:4:"name";s:6:"remark";s:4:"type";s:7:"varchar";s:6:"length";s:3:"500";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:3:"uid";}}s:8:"username";a:3:{s:4:"name";s:8:"username";s:4:"type";s:6:"unique";s:6:"fields";a:1:{i:0;s:8:"username";}}}}i:65;a:6:{s:9:"tablename";s:15:"ims_users_group";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"4";s:6:"fields";a:5:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"name";a:6:{s:4:"name";s:4:"name";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"package";a:7:{s:4:"name";s:7:"package";s:4:"type";s:7:"varchar";s:6:"length";s:4:"5000";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"maxaccount";a:7:{s:4:"name";s:10:"maxaccount";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:13:"maxsubaccount";a:6:{s:4:"name";s:13:"maxsubaccount";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}i:66;a:6:{s:9:"tablename";s:20:"ims_users_invitation";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:5:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:4:"code";a:6:{s:4:"name";s:4:"code";s:4:"type";s:7:"varchar";s:6:"length";s:2:"64";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"fromuid";a:6:{s:4:"name";s:7:"fromuid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:9:"inviteuid";a:6:{s:4:"name";s:9:"inviteuid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:8:"idx_code";a:3:{s:4:"name";s:8:"idx_code";s:4:"type";s:6:"unique";s:6:"fields";a:1:{i:0;s:4:"code";}}}}i:67;a:6:{s:9:"tablename";s:17:"ims_users_profile";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:9:"increment";s:1:"1";s:6:"fields";a:44:{s:2:"id";a:6:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;}s:3:"uid";a:6:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"createtime";a:6:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"realname";a:7:{s:4:"name";s:8:"realname";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"nickname";a:7:{s:4:"name";s:8:"nickname";s:4:"type";s:7:"varchar";s:6:"length";s:2:"20";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"avatar";a:7:{s:4:"name";s:6:"avatar";s:4:"type";s:7:"varchar";s:6:"length";s:3:"100";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:2:"qq";a:7:{s:4:"name";s:2:"qq";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"mobile";a:7:{s:4:"name";s:6:"mobile";s:4:"type";s:7:"varchar";s:6:"length";s:2:"11";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"fakeid";a:6:{s:4:"name";s:6:"fakeid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"vip";a:7:{s:4:"name";s:3:"vip";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:6:"gender";a:7:{s:4:"name";s:6:"gender";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"1";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"birthyear";a:7:{s:4:"name";s:9:"birthyear";s:4:"type";s:8:"smallint";s:6:"length";s:1:"6";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:10:"birthmonth";a:7:{s:4:"name";s:10:"birthmonth";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:8:"birthday";a:7:{s:4:"name";s:8:"birthday";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:7:"default";s:1:"0";s:6:"signed";b:0;s:9:"increment";b:0;}s:13:"constellation";a:7:{s:4:"name";s:13:"constellation";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"zodiac";a:7:{s:4:"name";s:6:"zodiac";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"telephone";a:7:{s:4:"name";s:9:"telephone";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"idcard";a:7:{s:4:"name";s:6:"idcard";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"studentid";a:7:{s:4:"name";s:9:"studentid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"grade";a:7:{s:4:"name";s:5:"grade";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"address";a:7:{s:4:"name";s:7:"address";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"zipcode";a:7:{s:4:"name";s:7:"zipcode";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:11:"nationality";a:7:{s:4:"name";s:11:"nationality";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"resideprovince";a:7:{s:4:"name";s:14:"resideprovince";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"residecity";a:7:{s:4:"name";s:10:"residecity";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"residedist";a:7:{s:4:"name";s:10:"residedist";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:14:"graduateschool";a:7:{s:4:"name";s:14:"graduateschool";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"company";a:7:{s:4:"name";s:7:"company";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"education";a:7:{s:4:"name";s:9:"education";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"occupation";a:7:{s:4:"name";s:10:"occupation";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"position";a:7:{s:4:"name";s:8:"position";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:7:"revenue";a:7:{s:4:"name";s:7:"revenue";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:15:"affectivestatus";a:7:{s:4:"name";s:15:"affectivestatus";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:10:"lookingfor";a:7:{s:4:"name";s:10:"lookingfor";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:9:"bloodtype";a:7:{s:4:"name";s:9:"bloodtype";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"height";a:7:{s:4:"name";s:6:"height";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"weight";a:7:{s:4:"name";s:6:"weight";s:4:"type";s:7:"varchar";s:6:"length";s:1:"5";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"alipay";a:7:{s:4:"name";s:6:"alipay";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"msn";a:7:{s:4:"name";s:3:"msn";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:5:"email";a:7:{s:4:"name";s:5:"email";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:6:"taobao";a:7:{s:4:"name";s:6:"taobao";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:4:"site";a:7:{s:4:"name";s:4:"site";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:7:"default";s:0:"";s:6:"signed";b:1;s:9:"increment";b:0;}s:3:"bio";a:6:{s:4:"name";s:3:"bio";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}s:8:"interest";a:6:{s:4:"name";s:8:"interest";s:4:"type";s:4:"text";s:6:"length";s:0:"";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;}}s:7:"indexes";a:1:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}}}}';

$datas = array();
//公众号相关
$datas[] = "INSERT INTO `ims_account` (`acid`, `uniacid`, `hash`, `type`, `isconnect`) VALUES(1, 1, 'uRr8qvQV', 1, 0);";
$datas[] = "INSERT INTO `ims_account_wechats` (`acid`, `uniacid`, `token`, `access_token`, `level`, `name`, `account`, `original`, `signature`, `country`, `province`, `city`, `username`, `password`, `lastupdate`, `key`, `secret`, `styleid`) VALUES (1, 1, 'omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP', '', 0, 'weizan', '', '', '', '', '', '', '', '', 0, '', '', 1);";
$datas[] = "INSERT INTO `ims_uni_account` (`uniacid`, `groupid`, `name`, `description`) VALUES(1, -1, '微赞团队', '一个朝气蓬勃的团队');";
$datas[] = "INSERT INTO `ims_uni_account_modules` (`id`, `uniacid`, `module`, `enabled`, `settings`) VALUES
(1, 1, 'basic', 1, ''),
(2, 1, 'news', 1, ''),
(3, 1, 'music', 1, ''),
(4, 1, 'userapi', 1, ''),
(5, 1, 'recharge', 1, '');";
$datas[] = "INSERT INTO `ims_uni_account_users` (`id`, `uniacid`, `uid`, `role`) VALUES(1, 1, 1, 'manager');";
$datas[] = "INSERT INTO `ims_uni_group` (`id`, `name`, `modules`, `templates`) VALUES(1, '体验套餐服务', 'N;', 'N;');";
$datas[] = <<<EOF
INSERT INTO `ims_uni_settings` (`uniacid`, `passport`, `oauth`, `uc`, `notify`, `creditnames`, `creditbehaviors`, `welcome`, `default`, `default_message`, `shortcuts`, `payment`, `groupdata`, `stat`, `bootstrap`, `menuset`, `default_site`) VALUES
(1, 'a:3:{s:8:"focusreg";i:0;s:4:"item";s:5:"email";s:4:"type";s:8:"password";}', 'a:2:{s:6:"status";s:1:"0";s:7:"account";s:1:"0";}', 'a:1:{s:6:"status";i:0;}', 'a:1:{s:3:"sms";a:2:{s:7:"balance";i:0;s:9:"signature";s:0:"";}}', 'a:5:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}s:7:"credit3";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit4";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit5";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}}', 'a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}', '', '', '', '', 'a:4:{s:6:"credit";a:1:{s:6:"switch";b:0;}s:6:"alipay";a:4:{s:6:"switch";b:0;s:7:"account";s:0:"";s:7:"partner";s:0:"";s:6:"secret";s:0:"";}s:6:"wechat";a:5:{s:6:"switch";b:0;s:7:"account";b:0;s:7:"signkey";s:0:"";s:7:"partner";s:0:"";s:3:"key";s:0:"";}s:8:"delivery";a:1:{s:6:"switch";b:0;}}', 'a:3:{s:8:"isexpire";i:0;s:10:"oldgroupid";s:0:"";s:7:"endtime";i:1410364919;}', '', '', '', 1);
EOF;

//微站相关
$datas[] = <<<EOF
INSERT INTO `ims_site_multi` (`id`, `uniacid`, `title`, `styleid`, `site_info`, `quickmenu`, `status`) VALUES
(1, 1, '微赞团队', 1, '', 'a:2:{s:8:"template";s:7:"default";s:12:"enablemodule";a:0:{}}', 1);
EOF;
$datas[] = "INSERT INTO `ims_site_styles` (`id`, `uniacid`, `templateid`, `name`) VALUES(1, 1, 1, '微站默认模板_gC5C');";
$datas[] = "INSERT INTO `ims_site_templates` (`id`, `name`, `title`, `description`, `author`, `url`, `type`) VALUES(1, 'default', '微站默认模板', '由微赞提供默认微站模板套系', '微赞团队', 'http://012wz.com', 1);";

//系统初始化数据
$datas[] = <<<EOF
INSERT INTO `ims_core_settings` (`key`, `value`) VALUES('authmode', 'i:1;'),('close', 'a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}');
EOF;
$datas[] = <<<EOF
INSERT INTO `ims_core_settings` (`key`, `value`) VALUES ('copyright', 'a:17:{s:8:"sitename";s:24:"微赞微信管理系统";s:3:"url";s:17:"http://www.012wz.com";s:8:"statcode";s:0:"";s:10:"footerleft";s:17:"powered by 012wz.com";s:11:"footerright";s:0:"";s:5:"flogo";s:0:"";s:5:"blogo";s:0:"";s:8:"baidumap";a:2:{s:3:"lng";s:10:"114.060055";s:3:"lat";s:9:"22.529554";}s:7:"company";s:39:"深圳市零壹贰科技有限公司";s:7:"address";s:68:"深圳市龙华新区民治大道展滔科技大厦A栋13A03";s:6:"person";s:9:"微赞";s:5:"phone";s:11:"15800008888";s:2:"qq";s:9:"800083075";s:5:"email";s:0:"";s:8:"keywords";s:82:"微赞,微信,微信公众平台,公众平台二次开发,公众平台开源软件";s:11:"description";s:82:"微赞,微信,微信公众平台,公众平台二次开发,公众平台开源软件";s:12:"showhomepage";i:1;}');
EOF;
$datas[] = <<<EOF
INSERT INTO `ims_core_settings` (`key`, `value`) VALUES ('register', 'a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}');
EOF;
$datas[] = <<<EOF
INSERT INTO `ims_core_settings` (`key`, `value`) VALUES ('addons','a:2:{s:10:"addons_url";s:23:"http://addons.012wz.com";s:5:"c_url";s:20:"http://www.012wz.com";}');
EOF;
$datas[] = "INSERT INTO `ims_mc_groups` (`groupid`, `uniacid`, `title`, `orderlist`, `isdefault`) VALUES(1, 1, '默认会员组', 0, 1);";

$datas[] = "
insert into `ims_modules`(`mid`,`name`,`type`,`title`,`version`,`ability`,`description`,`author`,`url`,`settings`,`subscribes`,`handles`,`isrulefields`,`issystem`,`issolution`,`target`) values
('1','basic','system','基本文字回复','1.0','和您进行简单对话','一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('2','news','system','基本混合图文回复','1.0','为你提供生动的图文资讯','一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('3','music','system','基本音乐回复','1.0','提供语音、音乐等音频类回复','在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('4','userapi','system','自定义接口回复','1.1','更方便的第三方接口设置','自定义接口又称第三方接口，可以让开发者更方便的接入微赞系统，高效的与微信公众平台进行对接整合。','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('5','recharge','system','会员中心充值模块','1.0','提供会员充值功能','','Weizan Team','http://www.012wz.com/','0','','','0','1','0','0'),
('6','chats','system','发送客服消息','1.0','公众号可以在粉丝最后发送消息的48小时内无限制发送消息','','Weizan Team','http://www.012wz.com/','0','','','0','1','0','0'),
('7','voice','system','基本语音回复','1.0','提供语音回复','在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('9','images','system','基本图片回复','1.0','提供图片回复','在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0'),
('10','video','system','基本视频回复','1.0','提供视频回复','在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。','Weizan Team','http://www.012wz.com/','0','','','1','1','0','0');

";

$datas[] = <<<EOF
insert into `ims_modules`(`mid`,`name`,`type`,`title`,`version`,`ability`,`description`,`author`,`url`,`settings`,`subscribes`,`handles`,`isrulefields`,`issystem`,`issolution`,`target`) values
('8','custom','system','多客服转接','1.0.0','用来接入腾讯的多客服系统','','Weizan Team','http://bbs.012wz.com','0','a:0:{}','a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}','1','1','0','0');
EOF;

$datas[] = "INSERT INTO `ims_users_group` (`id`, `name`, `package`, `maxaccount`, `maxsubaccount`) VALUES
(1, '体验用户组', 'a:1:{i:0;i:1;}', 1, 1),
(2, '白金用户组', 'a:1:{i:0;i:1;}', 2, 2),
(3, '黄金用户组', 'a:1:{i:0;i:1;}', 3, 3);";

$datas[] = <<<EOF
INSERT INTO `ims_cover_reply` (`id`, `uniacid`, `multiid`, `rid`, `module`, `do`, `title`, `description`, `thumb`, `url`) VALUES
(1, 1, 0, 7, 'mc', '', '个人中心入口设置', '', '', './index.php?c=mc&a=home&i=1'),
(2, 1, 1, 8, 'site', '', '微赞团队入口设置', '', '', './index.php?c=home&i=1&t=1');
EOF;

$datas[] = "INSERT INTO `ims_rule` (`id`, `uniacid`, `name`, `module`, `displayorder`, `status`) VALUES
(1, 0, '城市天气', 'userapi', 255, 1),
(2, 0, '百度百科', 'userapi', 255, 1),
(3, 0, '即时翻译', 'userapi', 255, 1),
(4, 0, '今日老黄历', 'userapi', 255, 1),
(5, 0, '看新闻', 'userapi', 255, 1),
(6, 0, '快递查询', 'userapi', 255, 1),
(7, 1, '个人中心入口设置', 'cover', 0, 1),
(8, 1, '微赞团队入口设置', 'cover', 0, 1);";

$datas[] = "INSERT INTO `ims_rule_keyword` (`id`, `rid`, `uniacid`, `module`, `content`, `type`, `displayorder`, `status`) VALUES
(1, 1, 0, 'userapi', '^.+天气$', 3, 255, 1),
(2, 2, 0, 'userapi', '^百科.+$', 3, 255, 1),
(3, 2, 0, 'userapi', '^定义.+$', 3, 255, 1),
(4, 3, 0, 'userapi', '^@.+$', 3, 255, 1),
(5, 4, 0, 'userapi', '日历', 1, 255, 1),
(6, 4, 0, 'userapi', '万年历', 1, 255, 1),
(7, 4, 0, 'userapi', '黄历', 1, 255, 1),
(8, 4, 0, 'userapi', '几号', 1, 255, 1),
(9, 5, 0, 'userapi', '新闻', 1, 255, 1),
(10, 6, 0, 'userapi', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$', 3, 255, 1),
(11, 7, 1, 'cover', '个人中心', 1, 0, 1),
(12, 8, 1, 'cover', '首页', 1, 0, 1);";

//系统服务回复
$datas[] = <<<EOF
INSERT INTO `ims_userapi_reply` (`id`, `rid`, `description`, `apiurl`, `token`, `default_text`, `cachetime`) VALUES
(1, 1, '"城市名+天气", 如: "北京天气"', 'weather.php', '', '', 0),
(2, 2, '"百科+查询内容" 或 "定义+查询内容", 如: "百科姚明", "定义自行车"', 'baike.php', '', '', 0),
(3, 3, '"@查询内容(中文或英文)"', 'translate.php', '', '', 0),
(4, 4, '"日历", "万年历", "黄历"或"几号"', 'calendar.php', '', '', 0),
(5, 5, '"新闻"', 'news.php', '', '', 0),
(6, 6, '"快递+单号", 如: "申通1200041125"', 'express.php', '', '', 0);
EOF;

$datas[] = <<<EOF
INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('system_frame', 'a:5:{s:8:"platform";a:3:{i:0;a:2:{s:5:"title";s:12:"基本功能";s:5:"items";a:8:{i:0;a:5:{s:2:"id";s:1:"3";s:5:"title";s:12:"文字回复";s:3:"url";s:38:"./index.php?c=platform&a=reply&m=basic";s:15:"permission_name";s:20:"platform_reply_basic";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:46:"./index.php?c=platform&a=reply&do=post&m=basic";}}i:1;a:5:{s:2:"id";s:1:"4";s:5:"title";s:12:"图文回复";s:3:"url";s:37:"./index.php?c=platform&a=reply&m=news";s:15:"permission_name";s:19:"platform_reply_news";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:45:"./index.php?c=platform&a=reply&do=post&m=news";}}i:2;a:5:{s:2:"id";s:1:"5";s:5:"title";s:12:"音乐回复";s:3:"url";s:38:"./index.php?c=platform&a=reply&m=music";s:15:"permission_name";s:20:"platform_reply_music";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:46:"./index.php?c=platform&a=reply&do=post&m=music";}}i:3;a:5:{s:2:"id";s:1:"6";s:5:"title";s:12:"图片回复";s:3:"url";s:39:"./index.php?c=platform&a=reply&m=images";s:15:"permission_name";s:21:"platform_reply_images";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:47:"./index.php?c=platform&a=reply&do=post&m=images";}}i:4;a:5:{s:2:"id";s:1:"7";s:5:"title";s:12:"语音回复";s:3:"url";s:38:"./index.php?c=platform&a=reply&m=voice";s:15:"permission_name";s:20:"platform_reply_voice";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:46:"./index.php?c=platform&a=reply&do=post&m=voice";}}i:5;a:5:{s:2:"id";s:1:"8";s:5:"title";s:12:"视频回复";s:3:"url";s:38:"./index.php?c=platform&a=reply&m=video";s:15:"permission_name";s:20:"platform_reply_video";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:46:"./index.php?c=platform&a=reply&do=post&m=video";}}i:6;a:5:{s:2:"id";s:1:"9";s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:48:"./index.php?c=platform&a=reply&do=post&m=userapi";}}i:7;a:4:{s:2:"id";s:2:"10";s:5:"title";s:12:"系统回复";s:3:"url";s:44:"./index.php?c=platform&a=special&do=display&";s:15:"permission_name";s:21:"platform_reply_system";}}}i:1;a:2:{s:5:"title";s:12:"高级功能";s:5:"items";a:6:{i:0;a:4:{s:2:"id";s:2:"12";s:5:"title";s:18:"常用服务接入";s:3:"url";s:43:"./index.php?c=platform&a=service&do=switch&";s:15:"permission_name";s:16:"platform_service";}i:1;a:4:{s:2:"id";s:2:"13";s:5:"title";s:15:"自定义菜单";s:3:"url";s:30:"./index.php?c=platform&a=menu&";s:15:"permission_name";s:13:"platform_menu";}i:2;a:4:{s:2:"id";s:2:"14";s:5:"title";s:18:"特殊消息回复";s:3:"url";s:44:"./index.php?c=platform&a=special&do=message&";s:15:"permission_name";s:16:"platform_special";}i:3;a:4:{s:2:"id";s:2:"15";s:5:"title";s:15:"二维码管理";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";}i:4;a:4:{s:2:"id";s:2:"16";s:5:"title";s:15:"多客服接入";s:3:"url";s:39:"./index.php?c=platform&a=reply&m=custom";s:15:"permission_name";s:21:"platform_reply_custom";}i:5;a:4:{s:2:"id";s:2:"17";s:5:"title";s:18:"长链接二维码";s:3:"url";s:32:"./index.php?c=platform&a=url2qr&";s:15:"permission_name";s:15:"platform_url2qr";}}}i:2;a:2:{s:5:"title";s:12:"数据统计";s:5:"items";a:4:{i:0;a:4:{s:2:"id";s:2:"19";s:5:"title";s:12:"聊天记录";s:3:"url";s:41:"./index.php?c=platform&a=stat&do=history&";s:15:"permission_name";s:21:"platform_stat_history";}i:1;a:4:{s:2:"id";s:2:"20";s:5:"title";s:24:"回复规则使用情况";s:3:"url";s:38:"./index.php?c=platform&a=stat&do=rule&";s:15:"permission_name";s:18:"platform_stat_rule";}i:2;a:4:{s:2:"id";s:2:"21";s:5:"title";s:21:"关键字命中情况";s:3:"url";s:41:"./index.php?c=platform&a=stat&do=keyword&";s:15:"permission_name";s:21:"platform_stat_keyword";}i:3;a:4:{s:2:"id";s:2:"22";s:5:"title";s:6:"参数";s:3:"url";s:41:"./index.php?c=platform&a=stat&do=setting&";s:15:"permission_name";s:21:"platform_stat_setting";}}}}s:4:"site";a:3:{i:0;a:2:{s:5:"title";s:12:"微站管理";s:5:"items";a:3:{i:0;a:5:{s:2:"id";s:2:"25";s:5:"title";s:12:"站点管理";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:18:"site_multi_display";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:35:"./index.php?c=site&a=multi&do=post&";}}i:1;a:4:{s:2:"id";s:2:"28";s:5:"title";s:12:"模板管理";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"site_style_template";}i:2;a:4:{s:2:"id";s:2:"29";s:5:"title";s:18:"模块模板扩展";s:3:"url";s:37:"./index.php?c=site&a=style&do=module&";s:15:"permission_name";s:17:"site_style_module";}}}i:1;a:2:{s:5:"title";s:18:"特殊页面管理";s:5:"items";a:2:{i:0;a:4:{s:2:"id";s:2:"31";s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:14:"site_editor_uc";}i:1;a:5:{s:2:"id";s:2:"32";s:5:"title";s:12:"专题页面";s:3:"url";s:36:"./index.php?c=site&a=editor&do=page&";s:15:"permission_name";s:16:"site_editor_page";s:6:"append";a:2:{s:5:"title";s:26:"<i class="fa fa-plus"></i>";s:3:"url";s:38:"./index.php?c=site&a=editor&do=design&";}}}}i:2;a:2:{s:5:"title";s:12:"功能组件";s:5:"items";a:2:{i:0;a:4:{s:2:"id";s:2:"34";s:5:"title";s:12:"分类设置";s:3:"url";s:30:"./index.php?c=site&a=category&";s:15:"permission_name";s:13:"site_category";}i:1;a:4:{s:2:"id";s:2:"35";s:5:"title";s:12:"文章管理";s:3:"url";s:29:"./index.php?c=site&a=article&";s:15:"permission_name";s:12:"site_article";}}}}s:2:"mc";a:5:{i:0;a:2:{s:5:"title";s:12:"粉丝管理";s:5:"items";a:2:{i:0;a:4:{s:2:"id";s:2:"38";s:5:"title";s:12:"粉丝分组";s:3:"url";s:28:"./index.php?c=mc&a=fangroup&";s:15:"permission_name";s:11:"mc_fangroup";}i:1;a:4:{s:2:"id";s:2:"39";s:5:"title";s:6:"粉丝";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";}}}i:1;a:2:{s:5:"title";s:12:"会员中心";s:5:"items";a:6:{i:0;a:4:{s:2:"id";s:2:"41";s:5:"title";s:24:"会员中心访问入口";s:3:"url";s:37:"./index.php?c=platform&a=cover&do=mc&";s:15:"permission_name";s:17:"platform_cover_mc";}i:1;a:4:{s:2:"id";s:2:"42";s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";}i:2;a:4:{s:2:"id";s:2:"43";s:5:"title";s:9:"会员组";s:3:"url";s:25:"./index.php?c=mc&a=group&";s:15:"permission_name";s:8:"mc_group";}i:3;a:4:{s:2:"id";s:2:"44";s:5:"title";s:18:"会员积分管理";s:3:"url";s:32:"./index.php?c=mc&a=creditmanage&";s:15:"permission_name";s:15:"mc_creditmanage";}i:4;a:4:{s:2:"id";s:2:"45";s:5:"title";s:18:"会员字段管理";s:3:"url";s:26:"./index.php?c=mc&a=fields&";s:15:"permission_name";s:9:"mc_fields";}i:5;a:4:{s:2:"id";s:2:"76";s:5:"title";s:18:"会员微信通知";s:3:"url";s:29:"./index.php?c=mc&a=tplnotice&";s:15:"permission_name";s:12:"mc_tplnotice";}}}i:2;a:2:{s:5:"title";s:15:"会员卡管理";s:5:"items";a:4:{i:0;a:4:{s:2:"id";s:2:"47";s:5:"title";s:21:"会员卡访问入口";s:3:"url";s:39:"./index.php?c=platform&a=cover&do=card&";s:15:"permission_name";s:19:"platform_cover_card";}i:1;a:4:{s:2:"id";s:2:"48";s:5:"title";s:15:"会员卡管理";s:3:"url";s:24:"./index.php?c=mc&a=card&";s:15:"permission_name";s:7:"mc_card";}i:2;a:4:{s:2:"id";s:2:"49";s:5:"title";s:12:"商家设置";s:3:"url";s:28:"./index.php?c=mc&a=business&";s:15:"permission_name";s:11:"mc_business";}i:3;a:4:{s:2:"id";s:2:"50";s:5:"title";s:18:"操作店员管理";s:3:"url";s:33:"./index.php?c=activity&a=offline&";s:15:"permission_name";s:16:"activity_offline";}}}i:3;a:2:{s:5:"title";s:12:"积分兑换";s:5:"items";a:5:{i:0;a:4:{s:2:"id";s:2:"52";s:5:"title";s:9:"折扣券";s:3:"url";s:32:"./index.php?c=activity&a=coupon&";s:15:"permission_name";s:15:"activity_coupon";}i:1;a:4:{s:2:"id";s:2:"53";s:5:"title";s:9:"代金券";s:3:"url";s:31:"./index.php?c=activity&a=token&";s:15:"permission_name";s:14:"activity_token";}i:2;a:4:{s:2:"id";s:2:"54";s:5:"title";s:12:"真实物品";s:3:"url";s:31:"./index.php?c=activity&a=goods&";s:15:"permission_name";s:14:"activity_goods";}i:3;a:4:{s:2:"id";s:2:"55";s:5:"title";s:12:"微信卡券";s:3:"url";s:30:"./index.php?c=wechat&a=manage&";s:15:"permission_name";s:13:"wechat_manage";}i:4;a:4:{s:2:"id";s:2:"56";s:5:"title";s:12:"卡券核销";s:3:"url";s:31:"./index.php?c=wechat&a=consume&";s:15:"permission_name";s:14:"wechat_consume";}}}i:4;a:2:{s:5:"title";s:12:"通知中心";s:5:"items";a:3:{i:0;a:4:{s:2:"id";s:2:"58";s:5:"title";s:19:"群发消息&通知";s:3:"url";s:29:"./index.php?c=mc&a=broadcast&";s:15:"permission_name";s:12:"mc_broadcast";}i:1;a:4:{s:2:"id";s:2:"59";s:5:"title";s:12:"微信群发";s:3:"url";s:24:"./index.php?c=mc&a=mass&";s:15:"permission_name";s:7:"mc_mass";}i:2;a:4:{s:2:"id";s:2:"60";s:5:"title";s:12:"通知参数";s:3:"url";s:31:"./index.php?c=profile&a=notify&";s:15:"permission_name";s:14:"profile_notify";}}}}s:7:"setting";a:3:{i:0;a:2:{s:5:"title";s:15:"公众号选项";s:5:"items";a:3:{i:0;a:4:{s:2:"id";s:2:"63";s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";}i:1;a:4:{s:2:"id";s:2:"64";s:5:"title";s:19:"借用 oAuth 权限";s:3:"url";s:37:"./index.php?c=mc&a=passport&do=oauth&";s:15:"permission_name";s:17:"mc_passport_oauth";}i:2;a:4:{s:2:"id";s:2:"65";s:5:"title";s:22:"借用 JS 分享权限";s:3:"url";s:31:"./index.php?c=profile&a=jsauth&";s:15:"permission_name";s:14:"profile_jsauth";}}}i:1;a:2:{s:5:"title";s:21:"会员及粉丝选项";s:5:"items";a:4:{i:0;a:4:{s:2:"id";s:2:"67";s:5:"title";s:12:"积分设置";s:3:"url";s:26:"./index.php?c=mc&a=credit&";s:15:"permission_name";s:9:"mc_credit";}i:1;a:4:{s:2:"id";s:2:"68";s:5:"title";s:12:"注册设置";s:3:"url";s:40:"./index.php?c=mc&a=passport&do=passport&";s:15:"permission_name";s:20:"mc_passport_passport";}i:2;a:4:{s:2:"id";s:2:"69";s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:36:"./index.php?c=mc&a=passport&do=sync&";s:15:"permission_name";s:16:"mc_passport_sync";}i:3;a:4:{s:2:"id";s:2:"70";s:5:"title";s:14:"UC站点整合";s:3:"url";s:22:"./index.php?c=mc&a=uc&";s:15:"permission_name";s:5:"mc_uc";}}}i:2;a:1:{s:5:"title";s:18:"其他功能选项";}}s:3:"ext";a:1:{i:0;a:2:{s:5:"title";s:6:"管理";s:5:"items";a:1:{i:0;a:4:{s:2:"id";s:2:"74";s:5:"title";s:18:"扩展功能管理";s:3:"url";s:31:"./index.php?c=profile&a=module&";s:15:"permission_name";s:14:"profile_module";}}}}}');
EOF;

$datas[] = "INSERT INTO `ims_profile_fields` (`id`, `field`, `available`, `title`, `description`, `displayorder`, `required`, `unchangeable`, `showinregister`) VALUES
(1, 'realname', 1, '真实姓名', '', 0, 1, 1, 1),
(2, 'nickname', 1, '昵称', '', 1, 1, 0, 1),
(3, 'avatar', 1, '头像', '', 1, 0, 0, 0),
(4, 'qq', 1, 'QQ号', '', 0, 0, 0, 1),
(5, 'mobile', 1, '手机号码', '', 0, 0, 0, 0),
(6, 'vip', 1, 'VIP级别', '', 0, 0, 0, 0),
(7, 'gender', 1, '性别', '', 0, 0, 0, 0),
(8, 'birthyear', 1, '出生生日', '', 0, 0, 0, 0),
(9, 'constellation', 1, '星座', '', 0, 0, 0, 0),
(10, 'zodiac', 1, '生肖', '', 0, 0, 0, 0),
(11, 'telephone', 1, '固定电话', '', 0, 0, 0, 0),
(12, 'idcard', 1, '证件号码', '', 0, 0, 0, 0),
(13, 'studentid', 1, '学号', '', 0, 0, 0, 0),
(14, 'grade', 1, '班级', '', 0, 0, 0, 0),
(15, 'address', 1, '邮寄地址', '', 0, 0, 0, 0),
(16, 'zipcode', 1, '邮编', '', 0, 0, 0, 0),
(17, 'nationality', 1, '国籍', '', 0, 0, 0, 0),
(18, 'resideprovince', 1, '居住地址', '', 0, 0, 0, 0),
(19, 'graduateschool', 1, '毕业学校', '', 0, 0, 0, 0),
(20, 'company', 1, '公司', '', 0, 0, 0, 0),
(21, 'education', 1, '学历', '', 0, 0, 0, 0),
(22, 'occupation', 1, '职业', '', 0, 0, 0, 0),
(23, 'position', 1, '职位', '', 0, 0, 0, 0),
(24, 'revenue', 1, '年收入', '', 0, 0, 0, 0),
(25, 'affectivestatus', 1, '情感状态', '', 0, 0, 0, 0),
(26, 'lookingfor', 1, ' 交友目的', '', 0, 0, 0, 0),
(27, 'bloodtype', 1, '血型', '', 0, 0, 0, 0),
(28, 'height', 1, '身高', '', 0, 0, 0, 0),
(29, 'weight', 1, '体重', '', 0, 0, 0, 0),
(30, 'alipay', 1, '支付宝帐号', '', 0, 0, 0, 0),
(31, 'msn', 1, 'MSN', '', 0, 0, 0, 0),
(32, 'email', 1, '电子邮箱', '', 0, 0, 0, 0),
(33, 'taobao', 1, '阿里旺旺', '', 0, 0, 0, 0),
(34, 'site', 1, '主页', '', 0, 0, 0, 0),
(35, 'bio', 1, '自我介绍', '', 0, 0, 0, 0),
(36, 'interest', 1, '兴趣爱好', '', 0, 0, 0, 0);";

$datas[] = "
ALTER TABLE `ims_account_wechats` ADD   `jsapi_ticket` varchar(1000) NOT NULL;
ALTER TABLE `ims_account_wechats` ADD   `subscribeurl` varchar(120) NOT NULL;

ALTER TABLE `ims_activity_coupon_record`  ADD   `operator` varchar(30) NOT NULL;
ALTER TABLE `ims_business` change `thumb`  `thumb` varchar(255) NOT NULL;

ALTER TABLE `ims_core_paylog` change   `plid` `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `ims_core_sessions` change   `data` `data` varchar(5000) NOT NULL;

ALTER TABLE `ims_mc_credits_record` change `num`  `num` decimal(10,2) NOT NULL;

ALTER TABLE `ims_mc_handsel` change  `fromuid` `fromuid` varchar(32) NOT NULL;

ALTER TABLE `ims_mc_mapping_fans` change  `tag` `tag` varchar(1000) NOT NULL;
ALTER TABLE `ims_mc_mapping_fans` ADD `nickname` varchar(50) NOT NULL;
ALTER TABLE `ims_mc_mapping_fans` ADD `groupid` int(10) unsigned NOT NULL;
ALTER TABLE `ims_mc_mapping_fans` ADD  `updatetime` int(10) unsigned DEFAULT NULL;

ALTER TABLE `ims_news_reply` ADD  `author` varchar(64) NOT NULL;
ALTER TABLE `ims_news_reply` change   `thumb` `thumb` varchar(255) NOT NULL;
ALTER TABLE `ims_news_reply` add  `createtime` int(10) NOT NULL;

ALTER TABLE `ims_site_article` change    `thumb` `thumb` varchar(255) NOT NULL;
ALTER TABLE `ims_site_article` change  `source` `source` varchar(255) NOT NULL;
ALTER TABLE `ims_site_article` add  `incontent` tinyint(1) NOT NULL;

ALTER TABLE `ims_site_multi` change `site_info` `site_info` text NOT NULL;
ALTER TABLE `ims_site_multi` add  `bindhost` varchar(255) NOT NULL;

ALTER TABLE `ims_site_nav` add `categoryid` int(10) unsigned NOT NULL;
ALTER TABLE `ims_site_slide` add    `multiid` int(10) unsigned NOT NULL;

ALTER TABLE `ims_site_styles_vars` add  `description` varchar(50) NOT NULL;

ALTER TABLE `ims_site_templates` add `version` varchar(64) NOT NULL;

ALTER TABLE `ims_uni_settings` add  `jsauth_acid` int(10) unsigned NOT NULL;

DROP TABLE IF EXISTS  `ims_core_wechats_attachment`;
CREATE TABLE `ims_core_wechats_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `media_id` varchar(255) NOT NULL,
  `type` varchar(15) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `media_id` (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS  `ims_custom_reply`;
CREATE TABLE `ims_custom_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `start1` int(10) NOT NULL DEFAULT '-1',
  `end1` int(10) NOT NULL DEFAULT '-1',
  `start2` int(10) NOT NULL DEFAULT '-1',
  `end2` int(10) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_images_reply`;
CREATE TABLE `ims_images_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS  `ims_mc_chats_record`;
CREATE TABLE `ims_mc_chats_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL,
  `openid` varchar(32) NOT NULL,
  `msgtype` varchar(15) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`),
  KEY `openid` (`openid`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS  `ims_mc_fans_groups`;
CREATE TABLE `ims_mc_fans_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groups` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_mc_mass_record`;
CREATE TABLE `ims_mc_mass_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `fansnum` int(10) unsigned NOT NULL,
  `msgtype` varchar(10) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_mc_member_fields`;
CREATE TABLE `ims_mc_member_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `fieldid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_fieldid` (`fieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_users_permission`;
CREATE TABLE `ims_users_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_video_reply`;
CREATE TABLE `ims_video_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_voice_reply`;
CREATE TABLE `ims_voice_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ims_uni_account_modules
ALTER TABLE `ims_uni_account_modules` ADD INDEX `idx_uniacid` (`uniacid`);

-- ims_modules
ALTER TABLE `ims_modules` ADD INDEX `idx_issystem` (`issystem`);

-- ims_rule_keyword
ALTER TABLE `ims_rule_keyword` ADD INDEX `idx_rid` (`rid`);
ALTER TABLE `ims_rule_keyword` ADD INDEX `idx_uniacid_type_content` (`uniacid`,`type`,`content`);

ALTER TABLE `ims_basic_reply` ADD INDEX(`rid`);
ALTER TABLE `ims_news_reply` ADD INDEX(`rid`);
ALTER TABLE `ims_music_reply` ADD INDEX(`rid`);
ALTER TABLE `ims_article_reply` ADD INDEX(`rid`);
ALTER TABLE `ims_cover_reply` ADD INDEX(`rid`);

ALTER TABLE `ims_userapi_reply` ADD INDEX(`rid`);

alter table `ims_qrcode` add `type` tinyint(1) unsigned NOT NULL DEFAULT '0';

-- 20150412

ALTER TABLE `ims_mc_mapping_fans` ADD INDEX(`updatetime`);
ALTER TABLE `ims_mc_mapping_fans` ADD INDEX(`nickname`);
ALTER TABLE `ims_site_multi` ADD INDEX(`bindhost`);

CREATE TABLE IF NOT EXISTS `ims_mc_oauth_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_openid` varchar(50) NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_oauthopenid_acid` (`oauth_openid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 20150423

ALTER TABLE `ims_account_wechats` ADD `card_ticket` varchar(1000) NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_activity_coupon_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `couponid` int(10) unsigned NOT NULL,
  `module` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `couponid` (`couponid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `ims_core_paylog` ADD `acid` int(10) unsigned NOT NULL;
ALTER TABLE `ims_core_paylog` ADD  `is_usecard` tinyint(3) unsigned NOT NULL;
ALTER TABLE `ims_core_paylog` ADD  `card_type` tinyint(3) unsigned NOT NULL;
ALTER TABLE `ims_core_paylog` ADD  `card_id` varchar(50) NOT NULL;
ALTER TABLE `ims_core_paylog` ADD  `card_fee` decimal(10,2) unsigned NOT NULL;
ALTER TABLE `ims_core_paylog` ADD  `encrypt_code` varchar(100) NOT NULL;
ALTER TABLE `ims_core_queue` ADD  `type` tinyint(3) unsigned NOT NULL;

ALTER TABLE `ims_qrcode` CHANGE  `type` `type` varchar(10) NOT NULL;
ALTER TABLE `ims_qrcode` ADD  `extra` int(10) unsigned NOT NULL;

ALTER TABLE `ims_site_article`  ADD  `click` int(10) unsigned NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `logo_url` varchar(150) NOT NULL,
  `code_type` tinyint(3) unsigned NOT NULL,
  `brand_name` varchar(15) NOT NULL,
  `title` varchar(15) NOT NULL,
  `sub_title` varchar(20) NOT NULL,
  `color` varchar(15) NOT NULL,
  `notice` varchar(15) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date_info` varchar(200) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `location_id_list` varchar(1000) NOT NULL,
  `use_custom_code` tinyint(3) NOT NULL,
  `bind_openid` tinyint(3) unsigned NOT NULL,
  `can_share` tinyint(3) unsigned NOT NULL,
  `can_give_friend` tinyint(3) unsigned NOT NULL,
  `get_limit` tinyint(3) unsigned NOT NULL,
  `service_phone` varchar(20) NOT NULL,
  `extra` varchar(1000) NOT NULL,
  `source` varchar(20) NOT NULL,
  `url_name_type` varchar(20) NOT NULL,
  `custom_url` varchar(100) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `ims_coupon_location`;
CREATE TABLE IF NOT EXISTS `ims_coupon_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) unsigned NOT NULL,
  `open_time` varchar(50) NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `offset_type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_coupon_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `module` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `card_id` (`card_id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_coupon_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `outer_id` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `friend_openid` varchar(50) NOT NULL,
  `givebyfriend` tinyint(3) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `usetime` int(10) unsigned NOT NULL,
  `status` tinyint(3) NOT NULL,
  `clerk_name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`),
  KEY `outer_id` (`outer_id`),
  KEY `card_id` (`card_id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_coupon_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) NOT NULL,
  `logourl` varchar(150) NOT NULL,
  `whitelist` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`,`acid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 0506

ALTER TABLE `ims_qrcode` ADD `url` varchar(80) NOT NULL;

-- 0520

ALTER TABLE `ims_site_nav` 
change  `section`  `section` tinyint(4) NOT NULL DEFAULT '1';

-- 0529
ALTER TABLE `ims_activity_coupon` 
add  `use_module` tinyint(3) unsigned NOT NULL;

ALTER TABLE `ims_core_wechats_attachment` 
 add `acid` int(10) unsigned NOT NULL,
 add `width` int(10) unsigned NOT NULL,
 add `height` int(10) unsigned NOT NULL,
 add `model` varchar(25) NOT NULL,
 add `tag` varchar(1000) NOT NULL;
 
ALTER TABLE `ims_modules` 
add  `iscard` tinyint(3) unsigned NOT NULL;

-- 0612
ALTER TABLE `ims_core_paylog` add `createtime` varchar(64) NOT NULL;
ALTER TABLE `ims_core_paylog` add `eso_tag` varchar(2000) NOT NULL DEFAULT '';

CREATE TABLE IF NOT EXISTS `ims_mc_member_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(50) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `address` varchar(512) NOT NULL,
  `isdefault` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uinacid` (`uniacid`),
  KEY `idx_uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 0703
ALTER TABLE `ims_mc_card` add `description` varchar(512) NOT NULL;

-- 0805
ALTER TABLE `ims_core_paylog` add `uniontid` varchar(64) NOT NULL;
ALTER TABLE `ims_qrcode` add `scene_str` varchar(64) NOT NULL;
ALTER TABLE `ims_qrcode_stat` add  `scene_str` varchar(64) NOT NULL;

-- 0831
ALTER TABLE `ims_account_wechats` ADD   `topad` varchar(225) NOT NULL;
ALTER TABLE `ims_account_wechats` ADD   `footad` varchar(225) NOT NULL;

ALTER TABLE `ims_account_wechats` ADD   `auth_refresh_token` varchar(255) NOT NULL;
INSERT INTO `ims_account_wechats` (`acid`, `uniacid`, `token`, `encodingaeskey`, `access_token`, `jsapi_ticket`, `level`, `name`, `account`, `original`, `signature`, `country`, `province`, `city`, `username`, `password`, `lastupdate`, `key`, `secret`, `styleid`, `subscribeurl`, `card_ticket`, `topad`, `footad`, `auth_refresh_token`) VALUES
(2, 2, 'u35ambyoahgg4g13dntuhohw5nbpxb4l', '', '', '', 4, '全网发布测试数据', '', '', '', '', '', '', '', '', 0, 'wx570bc396a51b8ff8', '', 0, '', '', '', '', '');
INSERT INTO `ims_account` (`acid`, `uniacid`, `hash`, `type`, `isconnect`) VALUES
(2, 2, '', 3, 0);
INSERT INTO `ims_uni_account` (`uniacid`, `groupid`, `name`, `description`) VALUES
(2, 0, '全网发布测试数据，发布完成后可删除', '微信开放平台全网发布测试数据，完成后可删除');
ALTER TABLE  `ims_users` add `ucuserid` int(10) unsigned NOT NULL;

-- 0919
ALTER TABLE `ims_users` ADD `viptime` varchar(13) NOT NULL;

ALTER TABLE `ims_users_group` ADD `maxsize` numeric(8,2) NOT NULL;

ALTER TABLE `ims_users` ADD   `starttime` int(10) unsigned NOT NULL;
ALTER TABLE `ims_users` ADD  `endtime` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_uni_group` ADD  `uniacid` int(10) unsigned NOT NULL;

ALTER TABLE  `ims_core_paylog` ADD  INDEX `uniontid` (`uniontid`);
ALTER TABLE  `ims_core_queue`  ADD  INDEX `module` (`module`);
ALTER TABLE   `ims_core_wechats_attachment` ADD  INDEX `acid` (`acid`);
ALTER TABLE  `ims_modules`  ADD  `permissions` varchar(5000) NOT NULL;
ALTER TABLE  `ims_modules_bindings` ADD    `url` varchar(100) NOT NULL;
ALTER TABLE  `ims_modules_bindings` ADD   `icon` varchar(50) NOT NULL;
ALTER TABLE  `ims_modules_bindings` ADD   `displayorder` tinyint(255) unsigned NOT NULL;
ALTER TABLE  `ims_site_slide`  ADD  INDEX `multiid` (`multiid`);
ALTER TABLE  `ims_uni_account` ADD  `default_acid` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_uni_account_users` ADD  INDEX `uniacid` (`uniacid`);
ALTER TABLE  `ims_uni_group` ADD  INDEX `uniacid` (`uniacid`);
ALTER TABLE  `ims_users_group` ADD `timelimit` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_users_permission` ADD   `type` varchar(30) NOT NULL;
ALTER TABLE  `ims_users_permission` ADD  `permission` varchar(10000) NOT NULL;
ALTER TABLE  `ims_users_profile` ADD   `workerid` varchar(64) NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_article_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `ims_article_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `cateid` (`cateid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `ims_article_unread_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notice_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `is_new` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `notice_id` (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `ims_core_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` tinyint(3) unsigned NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(60) NOT NULL,
  `append_title` varchar(30) NOT NULL,
  `append_url` varchar(60) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_system` tinyint(3) unsigned NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


INSERT INTO `ims_core_menu` (`id`, `pid`, `title`, `name`, `url`, `append_title`, `append_url`, `displayorder`, `type`, `is_display`, `is_system`, `permission_name`) VALUES
(1, 0, '基础设置', 'platform', '', 'fa fa-cog', '', 0, 'url', 1, 1, ''),
(2, 1, '基本功能', 'platform', '', '', '', 0, 'url', 1, 1, ''),
(3, 2, '文字回复', 'platform', './index.php?c=platform&a=reply&m=basic', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=basic', 0, 'url', 1, 1, 'platform_reply_basic'),
(4, 2, '图文回复', 'platform', './index.php?c=platform&a=reply&m=news', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=news', 0, 'url', 1, 1, 'platform_reply_news'),
(5, 2, '音乐回复', 'platform', './index.php?c=platform&a=reply&m=music', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=music', 0, 'url', 1, 1, 'platform_reply_music'),
(6, 2, '图片回复', 'platform', './index.php?c=platform&a=reply&m=images', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=images', 0, 'url', 1, 1, 'platform_reply_images'),
(7, 2, '语音回复', 'platform', './index.php?c=platform&a=reply&m=voice', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=voice', 0, 'url', 1, 1, 'platform_reply_voice'),
(8, 2, '视频回复', 'platform', './index.php?c=platform&a=reply&m=video', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=video', 0, 'url', 1, 1, 'platform_reply_video'),
(9, 2, '自定义接口回复', 'platform', './index.php?c=platform&a=reply&m=userapi', 'fa fa-plus', './index.php?c=platform&a=reply&do=post&m=userapi', 0, 'url', 1, 1, 'platform_reply_userapi'),
(10, 2, '系统回复', 'platform', './index.php?c=platform&a=special&do=display&', '', '', 0, 'url', 1, 1, 'platform_reply_system'),
(11, 1, '高级功能', 'platform', '', '', '', 0, 'url', 1, 1, ''),
(12, 11, '常用服务接入', 'platform', './index.php?c=platform&a=service&do=switch&', '', '', 0, 'url', 1, 1, 'platform_service'),
(13, 11, '自定义菜单', 'platform', './index.php?c=platform&a=menu&', '', '', 0, 'url', 1, 1, 'platform_menu'),
(14, 11, '特殊消息回复', 'platform', './index.php?c=platform&a=special&do=message&', '', '', 0, 'url', 1, 1, 'platform_special'),
(15, 11, '二维码管理', 'platform', './index.php?c=platform&a=qr&', '', '', 0, 'url', 1, 1, 'platform_qr'),
(16, 11, '多客服接入', 'platform', './index.php?c=platform&a=reply&m=custom', '', '', 0, 'url', 1, 1, 'platform_reply_custom'),
(17, 11, '长链接二维码', 'platform', './index.php?c=platform&a=url2qr&', '', '', 0, 'url', 1, 1, 'platform_url2qr'),
(18, 1, '数据统计', 'platform', '', '', '', 0, 'url', 1, 1, ''),
(19, 18, '聊天记录', 'platform', './index.php?c=platform&a=stat&do=history&', '', '', 0, 'url', 1, 1, 'platform_stat_history'),
(20, 18, '回复规则使用情况', 'platform', './index.php?c=platform&a=stat&do=rule&', '', '', 0, 'url', 1, 1, 'platform_stat_rule'),
(21, 18, '关键字命中情况', 'platform', './index.php?c=platform&a=stat&do=keyword&', '', '', 0, 'url', 1, 1, 'platform_stat_keyword'),
(22, 18, '参数', 'platform', './index.php?c=platform&a=stat&do=setting&', '', '', 0, 'url', 1, 1, 'platform_stat_setting'),
(23, 0, '微站功能', 'site', '', 'fa fa-life-bouy', '', 0, 'url', 1, 1, ''),
(24, 23, '微站管理', 'site', '', '', '', 0, 'url', 1, 1, ''),
(25, 24, '站点管理', 'site', './index.php?c=site&a=multi&do=display&', 'fa fa-plus', './index.php?c=site&a=multi&do=post&', 0, 'url', 1, 1, 'site_multi_display'),
(26, 24, '站点添加/编辑', 'site', '', '', '', 0, 'permission', 0, 1, 'site_multi_post'),
(27, 24, '站点删除', 'site', '', '', '', 0, 'permission', 0, 1, 'site_multi_del'),
(28, 24, '模板管理', 'site', './index.php?c=site&a=style&do=template&', '', '', 0, 'url', 1, 1, 'site_style_template'),
(29, 24, '模块模板扩展', 'site', './index.php?c=site&a=style&do=module&', '', '', 0, 'url', 1, 1, 'site_style_module'),
(30, 23, '特殊页面管理', 'site', '', '', '', 0, 'url', 1, 1, ''),
(31, 30, '会员中心', 'site', './index.php?c=site&a=editor&do=uc&', '', '', 0, 'url', 1, 1, 'site_editor_uc'),
(32, 30, '专题页面', 'site', './index.php?c=site&a=editor&do=page&', 'fa fa-plus', './index.php?c=site&a=editor&do=design&', 0, 'url', 1, 1, 'site_editor_page'),
(33, 23, '功能组件', 'site', '', '', '', 0, 'url', 1, 1, ''),
(34, 33, '分类设置', 'site', './index.php?c=site&a=category&', '', '', 0, 'url', 1, 1, 'site_category'),
(35, 33, '文章管理', 'site', './index.php?c=site&a=article&', '', '', 0, 'url', 1, 1, 'site_article'),
(36, 0, '粉丝营销', 'mc', '', 'fa fa-gift', '', 0, 'url', 1, 1, ''),
(37, 36, '粉丝管理', 'mc', '', '', '', 0, 'url', 1, 1, ''),
(38, 37, '粉丝分组', 'mc', './index.php?c=mc&a=fangroup&', '', '', 0, 'url', 1, 1, 'mc_fangroup'),
(39, 37, '粉丝', 'mc', './index.php?c=mc&a=fans&', '', '', 0, 'url', 1, 1, 'mc_fans'),
(40, 36, '会员中心', 'mc', '', '', '', 0, 'url', 1, 1, ''),
(41, 40, '会员中心访问入口', 'mc', './index.php?c=platform&a=cover&do=mc&', '', '', 0, 'url', 1, 1, 'platform_cover_mc'),
(42, 40, '会员', 'mc', './index.php?c=mc&a=member&', '', '', 0, 'url', 1, 1, 'mc_member'),
(43, 40, '会员组', 'mc', './index.php?c=mc&a=group&', '', '', 0, 'url', 1, 1, 'mc_group'),
(44, 40, '会员积分管理', 'mc', './index.php?c=mc&a=creditmanage&', '', '', 0, 'url', 1, 1, 'mc_creditmanage'),
(45, 40, '会员字段管理', 'mc', './index.php?c=mc&a=fields&', '', '', 0, 'url', 1, 1, 'mc_fields'),
(46, 36, '会员卡管理', 'mc', '', '', '', 0, 'url', 1, 1, ''),
(47, 46, '会员卡访问入口', 'mc', './index.php?c=platform&a=cover&do=card&', '', '', 0, 'url', 1, 1, 'platform_cover_card'),
(48, 46, '会员卡管理', 'mc', './index.php?c=mc&a=card&', '', '', 0, 'url', 1, 1, 'mc_card'),
(49, 46, '商家设置', 'mc', './index.php?c=mc&a=business&', '', '', 0, 'url', 1, 1, 'mc_business'),
(50, 46, '操作店员管理', 'mc', './index.php?c=activity&a=offline&', '', '', 0, 'url', 1, 1, 'activity_offline'),
(51, 36, '积分兑换', 'mc', '', '', '', 0, 'url', 1, 1, ''),
(52, 51, '折扣券', 'mc', './index.php?c=activity&a=coupon&', '', '', 0, 'url', 1, 1, 'activity_coupon'),
(53, 51, '代金券', 'mc', './index.php?c=activity&a=token&', '', '', 0, 'url', 1, 1, 'activity_token'),
(54, 51, '真实物品', 'mc', './index.php?c=activity&a=goods&', '', '', 0, 'url', 1, 1, 'activity_goods'),
(55, 51, '微信卡券', 'mc', './index.php?c=wechat&a=manage&', '', '', 0, 'url', 1, 1, 'wechat_manage'),
(56, 51, '卡券核销', 'mc', './index.php?c=wechat&a=consume&', '', '', 0, 'url', 1, 1, 'wechat_consume'),
(57, 36, '通知中心', 'mc', '', '', '', 0, 'url', 1, 1, ''),
(58, 57, '群发消息&通知', 'mc', './index.php?c=mc&a=broadcast&', '', '', 0, 'url', 1, 1, 'mc_broadcast'),
(59, 57, '微信群发', 'mc', './index.php?c=mc&a=mass&', '', '', 0, 'url', 1, 1, 'mc_mass'),
(60, 57, '通知参数', 'mc', './index.php?c=profile&a=notify&', '', '', 0, 'url', 1, 1, 'profile_notify'),
(61, 0, '功能选项', 'setting', '', 'fa fa-umbrella', '', 0, 'url', 1, 1, ''),
(62, 61, '公众号选项', 'setting', '', '', '', 0, 'url', 1, 1, ''),
(63, 62, '支付参数', 'setting', './index.php?c=profile&a=payment&', '', '', 0, 'url', 1, 1, 'profile_payment'),
(64, 62, '借用 oAuth 权限', 'setting', './index.php?c=mc&a=passport&do=oauth&', '', '', 0, 'url', 1, 1, 'mc_passport_oauth'),
(65, 62, '借用 JS 分享权限', 'setting', './index.php?c=profile&a=jsauth&', '', '', 0, 'url', 1, 1, 'profile_jsauth'),
(66, 61, '会员及粉丝选项', 'setting', '', '', '', 0, 'url', 1, 1, ''),
(67, 66, '积分设置', 'setting', './index.php?c=mc&a=credit&', '', '', 0, 'url', 1, 1, 'mc_credit'),
(68, 66, '注册设置', 'setting', './index.php?c=mc&a=passport&do=passport&', '', '', 0, 'url', 1, 1, 'mc_passport_passport'),
(69, 66, '粉丝同步设置', 'setting', './index.php?c=mc&a=passport&do=sync&', '', '', 0, 'url', 1, 1, 'mc_passport_sync'),
(70, 66, 'UC站点整合', 'setting', './index.php?c=mc&a=uc&', '', '', 0, 'url', 1, 1, 'mc_uc'),
(71, 61, '其他功能选项', 'setting', '', '', '', 0, 'url', 1, 1, ''),
(72, 0, '扩展功能', 'ext', '', 'fa fa-cubes', '', 0, 'url', 1, 1, ''),
(73, 72, '管理', 'ext', '', '', '', 0, 'url', 1, 1, ''),
(74, 73, '扩展功能管理', 'ext', './index.php?c=profile&a=module&', '', '', 0, 'url', 1, 1, 'profile_module'),
(75, 47, '店员操作访问入口', 'mc', './index.php?c=platform&a=cover&do=clerk&', '', '', 0, 'url', 1, 1, 'platform_cover_clerk'),
(76, 40, '会员微信通知', 'mc', './index.php?c=mc&a=tplnotice&', '', '', 0, 'url', 1, 1, 'mc_tplnotice');

CREATE TABLE IF NOT EXISTS `ims_site_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `multiid` (`multiid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- 1020
ALTER TABLE  `ims_activity_coupon_password` ADD   `mobile` varchar(20) NOT NULL;
ALTER TABLE  `ims_activity_coupon_password` ADD   `openid` varchar(50) NOT NULL;
ALTER TABLE  `ims_activity_coupon_password` ADD   `nickname` varchar(30) NOT NULL;
ALTER TABLE  `ims_activity_coupon_record` ADD    `clerk_id` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_activity_exchange` CHANGE  `description`   `description` text NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_activity_stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) unsigned NOT NULL,
  `opentime` varchar(50) NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE  `ims_coupon` ADD    `promotion_url_name` varchar(10) NOT NULL;
ALTER TABLE  `ims_coupon` ADD    `promotion_url` varchar(100) NOT NULL;
ALTER TABLE  `ims_coupon` ADD  `promotion_url_sub_title` varchar(10) NOT NULL;
ALTER TABLE  `ims_coupon_location` ADD    `sid` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_coupon_location` CHANGE   `introduction`   `introduction` varchar(255) NOT NULL;
ALTER TABLE  `ims_coupon_record` ADD   `clerk_id` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card` add   `discount_type` tinyint(3) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card` add   `discount` varchar(3000) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `grant` varchar(200) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `grant_rate` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card` add   `nums_status` tinyint(3) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card` add   `nums_text` varchar(15) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `nums` varchar(1000) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `times_status` tinyint(3) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card` add   `times_text` varchar(15) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `times` varchar(1000) NOT NULL;
ALTER TABLE  `ims_mc_card` add   `recharge` varchar(500) NOT NULL;
ALTER TABLE  `ims_mc_card_members` ADD    `openid` varchar(50) NOT NULL;
ALTER TABLE  `ims_mc_card_members` ADD   `nums` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card_members` ADD   `endtime` int(10) unsigned NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_mc_card_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `model` tinyint(3) unsigned NOT NULL,
  `fee` decimal(10,2) unsigned NOT NULL,
  `tag` varchar(10) NOT NULL,
  `note` varchar(255) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE  `ims_mc_credits_recharge` ADD   `openid` varchar(50) NOT NULL;
ALTER TABLE  `ims_mc_credits_recharge` ADD     `type` varchar(15) NOT NULL;
ALTER TABLE  `ims_mc_credits_recharge` ADD   `tag` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_credits_record` ADD    `module` varchar(30) NOT NULL;
ALTER TABLE  `ims_mc_credits_record` ADD    `clerk_id` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_groups` ADD    `credit` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_news_reply` CHANGE   `content`  `content` mediumtext NOT NULL;
ALTER TABLE  `ims_uni_settings` ADD     `recharge` varchar(500) NOT NULL;
ALTER TABLE  `ims_uni_settings` ADD    `tplnotice` varchar(1000) NOT NULL;
ALTER TABLE  `ims_uni_settings` ADD    `grouplevel` tinyint(3) unsigned NOT NULL;

-- 1027

ALTER TABLE  `ims_activity_coupon_password`  ADD  `storeid` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card`  ADD   `offset_rate` int(10) unsigned NOT NULL;
ALTER TABLE  `ims_mc_card`  ADD  `offset_max` int(10) NOT NULL;
ALTER TABLE  `ims_mc_credits_record`  ADD  `store_id` int(10) unsigned NOT NULL;

CREATE TABLE IF NOT EXISTS `ims_mc_card_care` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `credit1` int(10) unsigned NOT NULL,
  `credit2` int(10) unsigned NOT NULL,
  `couponid` int(10) unsigned NOT NULL,
  `granttime` int(10) unsigned NOT NULL,
  `days` int(10) unsigned NOT NULL,
  `time` tinyint(3) unsigned NOT NULL,
  `show_in_card` tinyint(3) unsigned NOT NULL,
  `content` varchar(1000) NOT NULL,
  `sms_notice` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_mc_card_credit_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `sign` varchar(1000) NOT NULL,
  `share` varchar(500) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `ims_mc_card_notices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `ims_mc_card_notices_unread` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `notice_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `is_new` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`),
  KEY `notice_id` (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ims_mc_card_recommend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_mc_card_sign_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `credit` int(10) unsigned NOT NULL,
  `is_grant` tinyint(3) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `ims_mc_cash_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `fee` decimal(10,2) unsigned NOT NULL,
  `final_fee` decimal(10,2) unsigned NOT NULL,
  `credit1` int(10) unsigned NOT NULL,
  `credit1_fee` decimal(10,2) unsigned NOT NULL,
  `credit2` decimal(10,2) unsigned NOT NULL,
  `cash` decimal(10,2) unsigned NOT NULL,
  `return_cash` decimal(10,2) unsigned NOT NULL,
  `final_cash` decimal(10,2) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

";

$dat = array();
$dat['schemas'] = unserialize($schemas);
$dat['datas'] = $datas;
return $dat;