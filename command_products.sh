#!/bin/bash

for loja in {10..20}
do
    docker exec gerador_placas_php php artisan products:recover --loja="$loja" &
done

wait
