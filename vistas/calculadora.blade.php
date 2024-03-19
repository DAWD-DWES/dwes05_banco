<div class="calculator card">
    <form action="index.php" method="POST">
        <input type="text" name="expresion" class="calculator-screen-expression z-depth-1" value="{{$expresion}}" readonly />
        <input type="text" name="valor" class="calculator-screen-value z-depth-1" value="{{$valor}}" readonly />

        <div class="calculator-keys">

            <input type="submit" class="operator btn btn-info" name="operador" value="+"/>
            <input type="submit" class="operator btn btn-info" name="operador" value="-"/>
            <input type="submit" class="operator btn btn-info" name="operador" value="*"/>
            <input type="submit" class="operator btn btn-info" name="operador" value="/"/>

            <input type="submit" name="digito" value="7" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="8" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="9" class="btn btn-light waves-effect"/>


            <input type="submit" name="digito" value="4" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="5" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="6" class="btn btn-light waves-effect"/>


            <input type="submit" name="digito" value="1" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="2" class="btn btn-light waves-effect"/>
            <input type="submit" name="digito" value="3" class="btn btn-light waves-effect"/>

            <input type="submit" name="reset" class="all-clear function btn btn-danger btn-sm" value="AC"/>
            <input type="submit" name="digito" value="0" class="btn btn-light waves-effect"/>
            <input type="submit" name="calcula" class="equal-sign operator btn btn-default" value="="/>

        </div>
    </form>
</div>


