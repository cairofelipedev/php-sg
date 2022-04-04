<?php
class Login extends Conexao
{

    private $login;
    private $password;

    public function setLogin($login)
    {
        $this->login = $login;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getLogin()
    {
        return $this->login;
    }
    public function getPassword()
    {
        return $this->password;
    }



    public function logar()
    {
        $pdo = parent::getDB();

        /*faço meu select com o banco de dados já criado*/
        $logar = $pdo->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
        $logar->bindValue(1, $this->getLogin());
        $logar->bindValue(2, $this->getPassword());
        $logar->execute();
        if ($logar->rowCount() == 1) :
            $dados = $logar->fetch(PDO::FETCH_OBJ);

            /*neste ponto informo a tabela que contem o dados do usurário*/
            $_SESSION['email'] = $dados->email;
            $_SESSION['name'] = $dados->name;
            $_SESSION['login'] = $dados->login;
            $_SESSION['type'] = $dados->type;
            $_SESSION['password'] = $dados->password;
            $_SESSION['id'] = $dados->id;
            $_SESSION['img'] = $dados->img;


            /*Aqui informo se o mesmo se encontra logado*/
            $_SESSION['logado'] = true;
            return true;
        else :
            return false;
        endif;
    }
}
