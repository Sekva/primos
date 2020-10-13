<h1>Criar trabalhos para o problema: {{$problema->nome}}</h1>

<p>Nota: Lembre-se da estrutura de criação de trabalhos de cada problema</p>
<p>Por exemplo, par ao problema 1, o número que será definido a baixo será a quantidade de p's para criação dos trabalhos.</p>

<br>
<hr>


<form action={{route('problemas.trabalhos.criar.salvar', $problema->id)}} method="post">
    {{csrf_field()}}
    <input type="hidden" name="id" value={{$problema->id}}>

    <label>Informa o número de trabalhos a ser criado:</label><br>
    <input type="number" name="quant" value=0 /><br><br>
    <input type="submit" value="Submit">
</form>
<hr>

<p>{{var_dump($problema)}}</p>
