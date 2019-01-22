<?php
session_start();
if(!isset($_SESSION['active_user'])){
    header("Location: index.php");
    exit();
}else{
    require_once('base.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php') ?>

<body>
    <section class="select">
      <?php 
    $query="SELECT sections_names.section_name FROM sections_names, users_sections WHERE sections_names.general = 1 OR users_sections.id_user = :user_id AND users_sections.id_section_name = sections_names.id_section";
        $result = $db->prepare($query);
    $result->bindValue(':user_id',$_SESSION['active_user'],PDO::PARAM_INT);
    $result->execute();
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        echo "<div data-section='{$row['section_name']}'><i></i><span>{$row['section_name']}.</span></div>";
    }
    
        ?>
    </section>
    <section class="lista_section"><div class="lista"><div></div><div><i class="fontello_in_future">+</i></div></div></section>
    <script>
    const btns = [...document.querySelectorAll(".select div")]
    const list = document.querySelector(".lista_section")
    let words_type_instantions=[]
    let list_instantions=[]
    
    class Words{
        constructor(element){
        this.element=element
        this.element.addEventListener('click',()=>{this.getWords()})
        this.words=[];
        }
        name(){return this.element.dataset.section}
        getWords(){
            const xhr = new XMLHttpRequest();
            xhr.onload=()=>{
                if(xhr.status===200){
                this.words=JSON.parse(xhr.responseText);
                this.print_words();
                move_list(true);
                }
            }
        xhr.open('POST','ajaxFiles/get_words.php',true);
        xhr.setRequestHeader('Content-type',"application/x-www-form-urlencoded");
        xhr.send('words_type='+JSON.stringify({val: this.element.dataset.section}))
        }
        print_words(){
            let lista =list_instantions[0].element.querySelector('div')
                lista.textContent='';
                this.words.forEach((e)=>{
                let span_word = document.createElement('span')
                span_word.textContent=e.word
                let span_description = document.createElement('span')
                span_description.textContent=e.description
                lista.appendChild(span_word)
                lista.appendChild(span_description)
            })
        }
        
    }
        class Lista{
            constructor(section_list){
                this.section=section_list
                this.element=this.section.querySelector('.lista')
                this.close_range=(window.innerWidth)/2
                this.start=0
                this.end=0
                this.element.querySelector('div:last-of-type').addEventListener('click',()=>{move_list()})
                this.element.addEventListener("touchstart",(e)=>{this.list_listener_start(e)})
                this.element.addEventListener("touchmove",(e)=>{this.list_listener_move(e)})
                this.element.addEventListener("touchend",(e)=>{this.list_listener_end(e)})
            }
            list_listener_start(e){
            //e.preventDefault();
            this.start=e.targetTouches[0].pageX
            this.end=e.targetTouches[0].pageX
            }
            list_listener_move(e){
            this.end = e.targetTouches[0].pageX
            }
            list_listener_end(){
            if((this.start-this.end)>this.close_range){
            move_list()
            } 
            if((this.end-this.start)>this.close_range){
            move_list()
            }
            }
            }
     const move_list=(acive=false)=>{
        if(acive){
        list_instantions[0].element.classList.add('active');
        list_instantions[0].section.classList.add('active');
        }else{
        list_instantions[0].element.classList.toggle('active');
        list_instantions[0].section.classList.toggle('active');
        }
         }

    btns.forEach((e)=>{
        words_type_instantions.push(new Words(e))
    })
    list_instantions.push(new Lista(list))

    </script>
    <a href="log_out.php">WYLOGUJ</a>
    </body>

</html>