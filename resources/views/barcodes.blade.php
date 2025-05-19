<!DOCTYPE html>
<html>
<head>
    
    <title>Barcodes</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .barcode-row {
            /* display: flex; */
            margin-right: 3px;
            /* max-width: 200px; */
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .barcode-id {
            flex-basis: 150px;
            font-weight: bold;
        }
        .barcode-img {
            width: 60px
        }
    </style>
</head>
<body>
    @foreach($barcodes as $barcode)
        <div class="barcode-row" style="display: inline-block;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <div class="barcode-id">{{$barcode['Product_id'].'-'. $barcode['id'] }}</div> 
            <img class="barcode-img" src="data:image/png;base64,{{ $barcode['barcode'] }}" alt="{{ $barcode['id'] }}">
        </div>
    @endforeach
</body>
</html>