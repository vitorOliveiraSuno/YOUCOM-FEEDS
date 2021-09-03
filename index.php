<?php

$rustart = getrusage();

$url = 'https://www.youcom.com.br/feeds/google-merchant';

$xmls = ['google_feed.xml', 'facebook_feed.xml', 'afilio_feed.xml', 'awin_feed.xml', 'bing_feed.xml', 'criteo_feed.xml', 'pinterest_feed.xml', 'rtbhouse_feed.xml', 'tiktok_feed.xml'];

if (!$arquivo_xml = simplexml_load_file($url)) {
    die('ERRO AO LER O ARQUIVO');
} else {
    foreach ($xmls as $index => $xml) {

        switch ($xml) {
            case 'afilio_feed.xml':
                $xmlContent = afilioXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'awin_feed.xml':
                $xmlContent = awinXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'bing_feed.xml':
                $xmlContent = bingXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'criteo_feed.xml':
                $xmlContent = criteoXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'facebook_feed.xml':
                $xmlContent = facebookXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'google_feed.xml':
                $xmlContent = googleXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'pinterest_feed.xml':
                $xmlContent = pinterestXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;

            case 'rtbhouse_feed.xml':
                $xmlContent = rtbhouseXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            case 'tiktok_feed.xml':
                $xmlContent = tiktokXML($arquivo_xml);
                $fp = fopen($xml, 'w+');
                fwrite($fp, $xmlContent);
                fclose($fp);
                break;
            default:
                break;
        }
    }
}

//Monitorar desempenho
function rutime($ru, $rus, $index)
{
    return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
        -  ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
}

$ru = getrusage();
echo "Esse processo utilizou " . rutime($ru, $rustart, "utime") .
    " ms para processamento\n";
echo "Levou " . rutime($ru, $rustart, "stime") .
    " ms em chamadas de sistema\n";

function googleXML($arquivo_xml)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <g:description>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->description . '</g:description>
                <link>' . $arquivo_xml->entry[$i]->link . '</link>
                <g:brand>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->brand . '</g:brand>
                <g:condition>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->condition . '</g:condition>
                <g:availability>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->availability . '</g:availability>
                <g:price>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->price . '</g:price>
                <g:gtin>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->gtin . '</g:gtin>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->sale_price . '</g:sale_price>
                ';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '<g:image_link>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image . '</g:image_link>';
        }
        $xml .= '
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</item_group_id>
                <g:custom_label_0>' . explode('|', $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->description)[0] . '</g:custom_label_0>
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->google_product_category . '</g:google_product_category>
                <g:installment>
                    <g:months>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->installment->months . '</g:months>
                    <g:amount>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->installment->amount . '</g:amount>               			
                <g:/installment>
                <g:age_group>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->age_group . '></g:age_group>
                <g:gender>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->gender . '</g:gender>
                <g:size>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->size . '</g:size>
                <g:color>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->color . '</g:color>
                ';

        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && !empty($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link)) {
            for ($j = 0; $j < count($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link); $j++) {
                $xml .= '<g:additional_image_link>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link . '</g:additional_image_link>
                ';
            }
        }
        $xml .=  '</item>';
    }

    $xml .= '
        </channel>
    </rss>';

    return $xml;
}

function afilioXML($arquivo_xml)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <Lista>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <produto>
                <id_produto>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</id_produto>
                <nome>' . $arquivo_xml->entry[$i]->title . '</nome>
                <descricao>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</descricao>
                <preco_promocao>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</preco_promocao>
                <preco_normal>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</preco_normal>
                <link_produto>' . $arquivo_xml->entry[$i]->link . '</link_produto>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <link_imagem>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</link_imagem>
                ';
        }
        $xml .= '<Moeda>&lt;![CDATA[R$]]&gt;</Moeda>
                <marca>&lt;![CDATA[Youcom]]&gt;</marca>
                <Categoria>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</Categoria>
                <parcelas>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->months . '</parcelas>
                <vl_parcelas>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->amount . '</vl_parcelas>
            ';
        $xml .=  '</produto>';
    }

    $xml .= '
        </Lista>
    </rss>';

    return $xml;
}

function awinXML($arquivo_xml)
{

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <product>
                <pid>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</pid>
                <name>' . $arquivo_xml->entry[$i]->title . '</name>
                <desc>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</desc>
                <purl>' . $arquivo_xml->entry[$i]->link . '</purl>';
            if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <imgurl>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</imgurl>
                ';
        }
        $xml .= '
                <price>
                    <rrpp>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</rrpp>
                    <actualp>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</actualp>
                </price>
                <condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</condition>
                <in_stock>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</in_stock>
                <brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</brand>
                <category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</category>
                <imagem_produto></imagem_produto>
                <parcelamento></parcelamento>
            </product>';
    }

    $xml .= '
        </channel>
    </rss>';

    return $xml;

}

function bingXML($arquivo_xml)
{

    $xml = '
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</description>
                <link>' . $arquivo_xml->entry[$i]->link . '</link>
                <g:brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</g:brand>
                <g:condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</g:condition>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:sale_price>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <g:image_link>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</g:image_link>
                ';
        }
        $xml .= '
                <g:availability>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</g:availability>
                <g:price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</g:price>
                <g:gtin>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gtin . '</g:gtin>
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</g:item_group_id>
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</g:google_product_category>
                <g:installment>
                    <g:months>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->months . '</g:months>
                    <g:amount>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->amount . '</g:amount>
                </g:installment>
            </item>';
    }
    $xml .= '
        </channel>
    </rss>';

    return $xml;

}

function criteoXML($arquivo_xml)
{

    $xml = '
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <g:description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</g:description>
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</g:google_product_category>
                <g:link>' . $arquivo_xml->entry[$i]->link . '</g:link>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <g:image_link>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</g:image_link>
                ';
        }
        $xml .= '
                <g:condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</g:condition>
                <g:availability>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</g:availability>
                <g:price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</g:price>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:sale_price>
                <g:brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</g:brand>
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</g:item_group_id>
                <g:color>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->color . '</g:color>
                <g:gender>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gender . '</g:gender>
                <g:size>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->size . '</g:size>
                <g:gtin>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gtin . '</g:gtin>
                <g:installment>
                    <g:month>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->month . '</g:month>
                    <g:amount>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->amount . '</g:amount>
                </g:installment>
            </item>';
    }
    $xml .= '
        </channel>
    </rss>';

    return $xml;

}

function facebookXML($arquivo_xml)
{
    $xml = '
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';
    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</description>
                <link>' . $arquivo_xml->link . '</link>
                <g:brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</g:brand>
                <g:condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</g:condition>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:sale_price>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <g:image_link>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</g:image_link>
                ';
        }
        $xml .= '
                <g:availability>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</g:availability>
                <g:price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</g:price>
                <g:gtin>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gtin . '</g:gtin>
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</g:item_group_id>
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</g:google_product_category>
                <g:installment>
                    <g:months>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->months . '</g:months>
                    <g:amount>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->installment->amount . '</g:amount>
                </g:installment>
                <g:shipping>
                    <g:country>BR</g:country>
                    <g:price>0 BRL</g:price>
                    <g:service>Standard</g:service>
                </g:shipping>';

        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && !empty($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link)) {
            for ($j = 0; $j < count($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link); $j++) {
                $xml .= '
                    <g:additional_image_link>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link . '</g:additional_image_link>
                    ';
            }
        }
        $xml .= '
                <g:gender>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gender . '</g:gender>
            </item>';
    }
    $xml .= '
        </channel>
    </rss>';

    return $xml;

}

function pinterestXML($arquivo_xml)
{
    $xml = '
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {


        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</description>
                <link>' . $arquivo_xml->entry[$i]->link . '</link>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <g:image_link>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</g:image_link>
                ';
        }
        $xml .= '
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</g:google_product_category>
                <g:gtin>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gtin . '</g:gtin>
                <g:price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</g:price>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:sale_price>
                <g:gender>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gender . '</g:gender>
                <g:installment></g:installment>
                <g:condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</g:condition>
                <g:availability>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</g:availability>
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</g:item_group_id>
                <g:brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</g:brand>
            </item>';
    }
    $xml .= '
        </channel>
    </rss>';

    return $xml;

}

function rtbhouseXML($arquivo_xml)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <products>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {
        $xml .= '
        <product>
            <id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</id>
            <name>' . $arquivo_xml->entry[$i]->title . '</name>
            <producturl>' . $arquivo_xml->entry[$i]->link . '</producturl>';
            if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
                $xml .= '
                <bigimage>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->images->image . '</bigimage>
                ';
            }
            $xml .= '<price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</price>
            <description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</description>
            <retailprice>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</retailprice>
            <instock>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</instock>
            <imagem_produto></imagem_produto>
            <parcelamento></parcelamento>
            <id_tag>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->product_id . '</id_tag>
        </product>';
    }
    $xml .= '</products>';

    return $xml;

}

function tiktokXML($arquivo_xml)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
        <channel>';

    for ($i = 0; $i < count($arquivo_xml->entry); $i++) {

        $xml .= '
            <item>
                <g:id>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->id . '</g:id>
                <title>' . $arquivo_xml->entry[$i]->title . '</title>
                <description>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->description . '</description>
                <link>' . $arquivo_xml->entry[$i]->link . '</link>
                <g:brand>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->brand . '</g:brand>
                <g:condition>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->condition . '</g:condition>
                <g:sale_price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:sale_price>';
        if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->image)) {
            $xml .= '
                <g:image_link>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->sale_price . '</g:image_link>
                ';
        }
        $xml .= '<g:availability>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->availability . '</g:availability>
                <g:price>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->price . '</g:price>
                <g:item_group_id>' . $arquivo_xml->entry[$i]->item_group_id . '</g:item_group_id>
                <g:google_product_category>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->google_product_category . '</g:google_product_category>';
                if (isset($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images) && !empty($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link)) {
                    for ($j = 0; $j < count($arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link); $j++) {
                        $xml .= '
                        <g:additional_image_link>' . $arquivo_xml->entry[$i]->children("http://base.google.com/ns/1.0")->images->additional_image_link . '</g:additional_image_link>
                        ';
                    }
                }
        $xml .= '<g:color>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->color . '</g:color>
                <g:size>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->size . '</g:size>
                <g:gender>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->gender . '</g:gender>
                <g:age_group>' . $arquivo_xml->entry[$i]->children('http://base.google.com/ns/1.0')->age_group . '</g:age_group>
            </item>';
    }
    $xml .= '
        </channel>
    </rss>';

    return $xml;

}
