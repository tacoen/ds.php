ds.php
======

code centralization, i'm no good in writing description


Setup:
======

in .htaccess

Rewriterule  ^(pack/([0-9])/)(.+)\.(.+)$ /ds.php?t=$4&p=$3&o=$2  [QSA,L]


Structure
=========

 - ds.php
 |
 \--php/function.php
 |
 \--js
 |  |
 |  \-- pack.php
 |  \-- plugins         (where .js scan start)
 |  \-- pack            (where pack-index saved)
 |
 \--css
    |
    \-- pack.php
    \-- plugins         (where .css scan start)
    \-- pack            (where pack-index saved)
