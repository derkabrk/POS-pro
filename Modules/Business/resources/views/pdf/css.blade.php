<style>
    * {
        margin: 0;
        padding: 0;
    }

    .in-container {
        padding: 24px
    }

    .sale-invoice {
        font-family: "Inter", sans-serif;
        font-size: 16px;
        font-weight: 600;
        line-height: 24.2px;
        text-align: center;

    }

    .in-pdf-title {
        font-family: "Inter", sans-serif;
        font-size: 20px;
        font-weight: 600;
        line-height: 24.2px;
        text-align: center;
        margin-top: 20px !important;
    }

    .table-header {
        text-align: center;
    }


    .invoice-container {
        /* width: 100%;
        max-width: 100%; */
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 0px;
        font-family: "Inter", sans-serif;
    }

    .in-content {
        /* width: 800px; */
        background-color: white;
        position: relative;
    }



    .in-table-header .head-red {
        background-color: #c52127 !important;
        color: white;
        padding: 12px 14px;
        font-weight: 700;
        font-size: 14px;
        border: .5px solid #D9D9D9;
        font-family: "Inter", sans-serif;

    }

    .in-table-header .head-black {
        background-color: black !important;
        color: white;
        padding: 14px 12px;
        font-weight: 700;
        font-size: 14px;
        border: .5px solid #D9D9D9;
        font-family: "Inter", sans-serif;

    }


    .in-table-body-container tr.in-table-body:nth-child(odd) {
        background-color: #fff;
    }

    .in-table-body-container tr.in-table-body:nth-child(even) {
        background-color: #C521271A;
    }

    .in-table-body td:first-child {
        border-left: 1px solid #D9D9D9;

    }

    .in-table-body td:last-child {
        border-right: 1px solid #D9D9D9;
    }

    .in-table-body:last-child td {
        border-bottom: 1px solid #D9D9D9;

    }

    .in-table-body-container {
        border: 1px solid #D9D9D9 !important;
    }

    .in-table-body td {
        padding: 5px 14px;
        border-left: .5px solid #D9D9D9;
        border-right: .5px solid #D9D9D9;
        font-size: 14px;
        font-family: "Inter", sans-serif;

    }

    .right-invoice {
        font-size: 30px;
        font-weight: 600;
        color: white;
        background-color: #000000;
        right: 0px;
        top: 20px;
        padding: 8px 18px;
        border-radius: 30px 0 0 30px;
        position: absolute;
        margin: 0;
        font-family: "Inter", sans-serif;

    }

    .invoice-logo {
        width: 54px;
        object-fit: contain;
        height: 54px;
    }

    .logo {
        padding-top: 12px;
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
        font-family: "Inter", sans-serif;
    }

    .invoice-header-content {
        display: table;
        width: 100%;
        table-layout: fixed;
        font-size: 12px;
        color: #424242;
        margin-bottom: 12px;
        min-width: 100%;
    }

    .invoice-header-content div {
        display: table-cell;
        vertical-align: middle;
        padding: 5px;
        width: 50%;
        /* সমানভাবে দুই পাশে ভাগ করে */
    }

    @media print {
        .invoice-header-content {
            display: table !important;
        }

        .invoice-header-content div {
            display: table-cell !important;
            width: 50% !important;
        }
    }


    .in-table-row td {
        padding-bottom: 8px;
        padding-top: 8px
    }

    .in-bottom-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        font-family: "Inter", sans-serif;
        margin-top: 12px;

    }

    .in-bottom-content {
        display: table;
        width: 100%;
        table-layout: fixed;
        font-size: 12px;
        margin-bottom: 12px;
        min-width: 100%;
    }

    .in-bottom-content div {
        display: table-cell;
        vertical-align: middle;
        padding: 5px;
        width: 30%;
    }

    @media print {
        .in-bottom-content {
            display: table !important;
        }

        .in-bottom-content div {
            display: table-cell !important;
            width: 50% !important;
        }
    }




    .pdf-table {
        margin-top: 16px;
    }

    .in-table-row-bottom td {
        border: none !important;
        font-size: 14px !important;
        font-weight: 600;
        padding-top: 10px;
        padding-left: 10px;
        padding-right: 10px;
        color: #424242;

    }

    .in-signature-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        margin-bottom: 1rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        font-family: "Inter", sans-serif;
    }


    .in-table-row-bottom .total-amound {
        background-color: #c52127;
        color: white;
        padding: 8px 6px;
    }

    .text-start {
        text-align: start;
    }

    .text-end {
        text-align: end !important;
        align-content: end !important;
    }

    .text-center {
        text-align: center
    }

    .in-table-row td {
        border: none !important;
        font-size: 12px !important;
    }

    .in-signature h4 {
        font-size: 14px !important;
        font-weight: 500;
        padding-top: 10px
    }

    .in-signature-container {
        width: 100%;
        font-family: "Inter", sans-serif;
        font-size: 12px;
        color: #424242;
        margin-bottom: 12px;
    }

    .in-signature-container .left-content {
        float: left;
    }

    .in-signature-container .right-content {
        float: right;
    }

    .pdf-footer {
        margin-top: 100px;
    }

    h4 {
        margin: 0;
    }

    .w-full {
        width: 100%;
    }

    .w-half {
        width: 50%;
    }

    .margin-top {
        margin-top: 1.25rem;
    }

    .footer {
        font-size: 0.875rem;
        padding: 1rem;
        background-color: rgb(241 245 249);
    }

    table {
        width: 100%;
        border-spacing: 0;
    }

    table.products {
        font-size: 0.875rem;
    }

    table.products tr {
        background-color: rgb(96 165 250);
    }

    table.products th {
        color: #ffffff;
        padding: 0.5rem;
    }

    table tr.items {
        background-color: rgb(241 245 249);
    }

    table tr.items td {
        padding: 0.5rem;
    }

    .total {
        text-align: right;
        margin-top: 1rem;
        font-size: 0.875rem;
    }
</style>
