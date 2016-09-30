### noneCms 该cms是基于thinkphp5，适用于企业站、个人博客，具有简便，灵活，开发快等优点。
常用标签
```
nav // 导航标签
article // 文章标签
product // 产品标签
web //系统关键参数标签
```
nav 示例：
```
{nav  orderby="sort DESC"}
//CODE...
{/nav }
参数：pid, // 父级栏目ID，可不指定，则为顶级栏目
orderby, // 排序规则
limit, // 限制条数
```
article 示例：
```
{article orderby="publishtime DESC" pagesize='15'}
//CODE...
{/article}
参数：cid, // 栏目ID
field, // 指定要取的字段
orderby, // 排序规则
limit, // 限制条数
pagesize // 分页 （pagesize 和 limit 只能选一个）
```

prodcut 示例：
```
{prodcut orderby="publishtime DESC" pagesize='15'}
//CODE...
{/prodcut }
参数：cid, // 栏目ID
field, // 指定要取的字段
orderby, // 排序规则
limit, // 限制条数
pagesize // 分页 （pagesize 和 limit 只能选一个）
```
web 示例：
```
{web name='keywords' /}

参数：name, // 可取值 keywords，description，title。。。

```
