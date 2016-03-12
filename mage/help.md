To get help quickly please provide the following information:

The link of your magento store with installed theme
Magento admin credentials
FTP details to let us fix bugs directly on your server
Detailed description of a problem you've got
Screenshots in 90% are very helpful so are really appreciated


在目录页面，属性过滤的基本原理：

- 查出所有可以过滤的属性；
- 遍历这些属性，创建每一个block；
- 根据url里面是否包含属性键值对，执行过滤；
- 使用state来管理过滤的状态。


Key points:

- layout;
- template;
