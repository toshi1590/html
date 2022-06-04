typeset i=1;

while [ $i -le 20 ]
do
  curl -X POST -d "pages=$i" localhost/for_nzdis/phpquery/yahoo.php > x
  wc x -l >> result.txt
  grep 'time: ' x >> result.txt
  i=`expr $i + 1`;
done
