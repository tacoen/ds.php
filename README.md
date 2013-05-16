ds.php
======

* code centralization, i'm no good in writing description
* require https://github.com/mrclay/minify

Setup:
======

in .htaccess, add 

   Rewriterule  ^(pack/([0-9])/)(.+)\.(.+)$ /ds.php?t=$4&p=$3&o=$2  [QSA,L]

edit php/function.php

   DEFINE (DOMAIN,"add_your_hostname_here");


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
