<div class="row">
    <h3>{ordernum}</h3>
    <h4> Customer: {customer}</h4>
    <h4> Order type: {order-type} </h4>
    <b>Special Instructions: <i>{special}</i></b>
    <hr>
    <br/>
    {burgers}
    <i>{name}</i>
    <br/>
    <ul>
        <li>Base: {patty}</li>
        <li>Top cheese: {top-cheese}</li>
        <li>Bottom cheese: {bottom-cheese}</li>
        <li>Topping(s): {topping}</li>
        <li>Sauce(s): {sauce}</li>
        <li>Instructions: {instructions}</li>
        <br/>
        <b>Burger Price: ${price}</b>
    </ul>
    <br/>
    {/burgers}
    <hr>
    <b>Order total: ${total}</b>
    <br/>
    <br/>
    <a href="/welcome">Back</a>
</div>