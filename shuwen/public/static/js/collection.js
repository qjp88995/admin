const weekArr = ['周日','周一','周二','周三','周四','周五','周六'];
const weekArr2 = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
const monthArr = ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'];
const fetchJson = (url,args)=>{
    return fetch(url,{
        method: 'post',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        mode: 'cors',
        credentials: 'include',
        body: JSON.stringify(args)
    }).then(async (data) => {
        let res = await data.json();
        if(res.code===403){
            window.location.href='/login';
        }
        return res;
    });
}

const getNewsList = (args={}) => {
    return fetchJson(`/news`,args);
}
const getExhibitionList = (args={}) => {
    return fetchJson(`/exhibition`,args);
}
const getCollectionList = (args={}) => {
    return fetchJson(`/collection`,args);
}
const getEducationList = (args={}) => {
    return fetchJson(`/education`,args);
}
const getEventsList = (args={}) => {
    return fetchJson(`/profile/events`,args);
}
// 左边导航
class Nav extends React.Component{
    constructor(props){
        super(props);
        this.state={
            menus: [
                {
                    title: '首　页',
                    href: '/'
                },
                {
                    title: '概　况',
                    href: '/profile',
                    children: [
                        {
                            title: '简　介',
                            href: '/profile#intro'
                        },
                        {
                            title: '机构设置',
                            href: '/profile#organization'
                        },
                        {
                            title: '开放信息',
                            href: '/profile#information'
                        },
                        {
                            title: '大事记',
                            href: '/profile#events'
                        },
                        {
                            title: '联系我们',
                            href: '/profile#contact'
                        },
                        {
                            title: '常见问题解答',
                            href: '/profile#question'
                        },
                    ]
                },
                {
                    title: '新闻资讯',
                    href: '/news',
                    children: [
                        {
                            title: '通知公告',
                            href: '/news#announcement'
                        },
                        {
                            title: '新　闻',
                            href: '/news#news'
                        },
                        {
                            title: '行业动态',
                            href: '/news#industry'
                        }
                    ]
                },
                {
                    title: '展览资讯',
                    href: '/exhibition',
                },
                {
                    title: '藏品欣赏',
                    href: '/collection'
                },
                {
                    title: '公共教育',
                    href: '/education',
                    // children: [
                    //     {
                    //         title: '活动资讯',
                    //         href: '/education'
                    //     }
                    // ]
                },
                {
                    title: '玉屏笛箫',
                    href: ''
                }
            ],
            spread: false,
            inputWidth: 0,
            inputPadding: 0,
            inputValue: ''
        }
    }
    groupMap = (menus) => {
        return(
            menus.map((item, index)=>{
                return(
                    <div className="item" style={{fontSize:'1.3vw'}}>
                        <a href={item.href}>{item.title}</a>
                        {
                            item.children&&item.children.length>0?
                            (
                                <div className="children">
                                {
                                    this.groupMap(item.children)
                                }
                                </div>
                            ):''
                        }
                    </div>
                );
            })
        );
    }
    componentDidMount(){
        document.addEventListener('click', ()=>{
            this.setState({
                inputWidth: 0,
                inputPadding: 0
            })
        })
    }
    componentWillUnmount(){
        document.removeEventListener('click', ()=>{
            this.setState({
                inputWidth: 0,
                inputPadding: 0
            })
        })
    }
    render(){
        return(
            <div className={'nav animated fadeInLeft'} style={{
                position: 'fixed',
                top: '0',
                left: '0',
                bottom: '0',
                background: 'rgb(160,35,41)',
                textAlign: 'center',
                minWidth:this.state.spread?'14vw':'8vw',
                transition: 'min-width 1s',
                fontFamily: 'fzls'
            }}>
                <div
                    style={{
                        height: '7vw',
                        position: 'relative'
                    }}
                >
                    <button
                        style={{
                            width: '3.4vw',
                            height: '2vw',
                            background: `url(${!this.state.spread?'/static/media/2/11.png':'/static/media/2/houtui.png'}) no-repeat left center / auto 100%`,
                            position: 'absolute',
                            bottom: '0',
                            left: '2.7vw',
                            transition: 'background 1s'
                        }}
                        onClick={()=>{
                            this.setState({
                                spread: !this.state.spread
                            })
                        }}
                    ></button>
                </div>
                <div
                    style={{
                        background: `url('/static/media/2/logo.png') no-repeat center / auto 100%`,
                        width: '8vw',
                        height: '7vw',
                        marginTop: '3vw'
                    }}
                />
                {
                    this.state.spread?
                    (
                        <div
                            className="group"
                            style={{
                                width: '100%',
                                textAlign: 'center',
                                color: 'white',
                                fontAize: '1.2vw',
                                marginTop: '2vw'
                            }}
                        >
                            {
                                this.groupMap(this.state.menus)
                            }
                        </div>
                    )
                    :
                    (
                        <div
                            style={{
                                width: '100%',
                                marginTop: '4vw',
                                textAlign: 'center',
                                color: 'white',
                                fontSize: '1.2vw',
                            }}
                            onClick={(e)=>{e.nativeEvent.stopImmediatePropagation();}}
                        >
                            <div
                                style={{
                                    margin: '0 3vw',
                                    padding:'0 0.5vw',
                                    borderLeft: '1px solid rgba(255,255,255,.5)',
                                    borderRight: '1px solid rgba(255,255,255,.5)',
                                }}
                            >
                                <input
                                    type="text"
                                    style={{
                                        width: `${this.state.inputWidth}px`,
                                        height: '1.5vw',
                                        outline: 'none',
                                        border: 'none',
                                        borderRadius: '5px',
                                        marginRight: '5px',
                                        padding: `0 ${this.state.inputPadding}px`,
                                        color: 'rgba(0,0,0,.7)',
                                        transition: 'padding,width 1s'
                                    }}
                                    onChange={(e)=>this.setState({
                                        inputValue:e.target.value
                                    })}
                                />
                                <button
                                    style={{
                                        width: '1.5vw',
                                        height: '1.5vw',
                                        background: `url('/static/media/1/search.png') no-repeat center / cover`,
                                        cursor: 'pointer',
                                        border: 'none',
                                        verticalAlign: 'middle',
                                    }}
                                    onClick={(e)=>{
                                        if(this.state.inputWidth===0){
                                            this.setState({
                                                inputWidth: 150,
                                                inputPadding: 5
                                            })
                                        }else{
                                            if(this.state.inputValue!==''){
                                                window.location.replace(`/search?title=${this.state.inputValue}`)
                                            }
                                        }
                                    }}
                                />
                            </div>
                        </div>
                    )
                }
            </div>
        );
    }
}

// 轮播图
class Banner extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            banners: this.props.banners,
            current: 0,
            total  : this.props.banners.length
        }
    }
    componentDidMount(){
        this.setState({
            lunboFun: setInterval(()=>{
                this.setState({
                    current: this.state.current+1>=this.state.total?0:this.state.current+1
                })
            },3000)
        })
    }
    render(){
        let btnWidth = 100/this.state.total>8.5?'8.5%':btnWidth+'%';
        return (
            <div className={'animated fadeInRight'} style={{position:'absolute',top:'0',background:'#000',width:'100%',height:'100%',overflow:'hidden'}}
                onMouseOver={()=>{
                    clearInterval(this.state.lunboFun);
                    this.setState({
                        lunboFun: undefined
                    })
                }}
                onMouseOut={()=>{
                    this.setState({
                        lunboFun: setInterval(()=>{
                            this.setState({
                                current: this.state.current+1>=this.state.total?0:this.state.current+1
                            })
                        },3000)
                    });
                }}
            >
                {
                    this.state.banners.map((item, index)=>{
                        let D = index-this.state.current;
                        return(
                            <div key={index} style={{
                                position:'absolute',
                                top:0,
                                left:0,
                                width:'100%',
                                height:'100%',
                                transition: 'transform 1s',
                                transform: `translateX(${100*D}%)`
                            }}>
                                <a href={item.href}>
                                    <img
                                        src={item.src}
                                        alt={item.title}
                                        style={{
                                            width:'100%',
                                            minHeight:'100%',
                                        }}
                                    />
                                </a>
                            </div>
                        );
                    })
                }
                <div style={{position:'absolute',bottom:'0',width:'100%',height:'4.6%',textAlign:'center'}}>
                    {
                        this.state.banners.map((item, index)=>{
                            return (
                                <span key={index}
                                    style={{
                                        display:'inline-block',
                                        margin: '0 0.5vw',
                                        background: this.state.current==index?'rgb(160,35,41)':'#fff',
                                        width: btnWidth,
                                        height: '3px',
                                        verticalAlign:'top',
                                        cursor: this.state.current==index?'default':'pointer',
                                        transition: 'background 1s'
                                    }}
                                    onClick={()=>(
                                        this.setState({
                                            current: index
                                        })
                                    )}
                                />
                            );
                        })
                    }
                </div>
            </div>
        );
    }
}

// 藏品列表
class CollectionList extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            list: [],
            limit: 8,
            current: 1,
            total: 1
        }
    }
    handleClickPage = (page) => {
        const { limit,current } = this.state;
        this.setState({
            current: page,
        });
        this.fetch({
            limit: limit,
            page: page,
        });
    }
    fetch = async (params = {}) => {
        const { limit,current } = this.state;
        let data = await getCollectionList({
            page: params.page || current,
            limit: params.limit || limit,
        });
        this.setState({
            list: data.data,
            total: data.count
        });
    }
    componentWillMount(){
        this.fetch();
    }
    render(){
        return(
            <div style={{width:'100%'}}>
            {
                this.state.list.map((item, index)=>{
                    return(
                        <div key={index}
                            className={'animated fadeIn'}
                            style={{
                                position:'relative',
                                background:`url('${item.src}') no-repeat center / cover`,
                                width: '29.32%',
                                paddingTop: '21.94%',
                                display:'inline-block',
                                marginBottom: '4%',
                                marginRight:`${(index+1)%3!==0?'6.02%':'0'}`
                            }}
                        >
                            <a href={item.href}>
                                <div style={{
                                        position:'absolute',
                                        top:'0',
                                        left:'0',
                                        width:'100%',
                                        height:'100%',
                                        padding: '20% 10% 0',
                                        transition: 'background,color 1s',
                                        background: 'rgba(0,0,0,0)',
                                        color: 'rgba(255,255,255,0)',
                                        textAlign: 'center',
                                        fontSize: '1.3vw'
                                    }}
                                    onMouseOver={(e)=>{
                                        e.target.style.background='rgba(0,0,0,0.6)';
                                        e.target.style.color='rgba(255,255,255,1)';
                                    }}
                                    onMouseOut={(e)=>{
                                        e.target.style.background='rgba(0,0,0,0)';
                                        e.target.style.color='rgba(255,255,255,0)';
                                    }}
                                >
                                    {item.title}
                                </div>
                            </a>
                        </div>
                    );
                })
            }
            <Pager
                limit={this.state.limit}
                current={this.state.current}
                total={this.state.total}
                maxShowPages={10}
                onClick={(page)=>{
                    this.handleClickPage(page);
                }}
            />
            </div>
        );
    }
}

// 展览列表
class ExhibitionList extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            list: [],
            limit: 9,
            current: 1,
            total: 1000
        }
    }
    async componentWillMount(){
        let list = await getExhibitionList();
        this.setState({
            list
        })
    }
    theTime = (startTime, endTime) => {
        let s = new Date(startTime.toString().length===10?startTime*1000:startTime);
        let e = new Date(endTime.toString().length===10?endTime*1000:endTime);
        return `${s.getFullYear()}年${s.getMonth()+1}月${s.getDate()}日(${weekArr[s.getDay()]})-${e.getMonth()+1}月${e.getDate()}日(${weekArr[e.getDay()]})`;
    }
    render(){
        let tags = ['历　史<br/>展　览', '当　前<br/>展　览', '展　览<br/>预　告'];
        let bgcolors = ['rgb(130,130,130)','rgb(177,143,98)','rgb(160,35,41)'];
        return(
            <div style={{width:'100%'}}>
            {
                this.state.list.map((item, index)=>{
                    let tag,bgcolor;
                    let now = Date.parse(new Date());
                    let s = item.startTime.toString().length===10?item.startTime*1000:item.startTime;
                    let e = item.endTime.toString().length===10?item.endTime*1000:item.endTime;
                    if(now >= s && now<e){
                        tag = tags[1];
                        bgcolor = bgcolors[1];
                    }else if(now<s){
                        tag = tags[2];
                        bgcolor = bgcolors[2];
                    }else{
                        tag = tags[0];
                        bgcolor = bgcolors[0];
                    }
                    return(
                        <div key={index} style={{
                            position:'relative',
                            background:`url('${item.src}') no-repeat center / 100%`,
                            width: '45%',
                            paddingTop: '21.94%',
                            display:'inline-block',
                            marginBottom: '4%',
                            marginRight:`${(index+1)%2!==0?'10%':'0'}`
                        }}>
                            <a href={item.href}>
                                <div style={{
                                        position:'absolute',
                                        bottom:'0',
                                        width:'100%',
                                        height:'25%',
                                        transition: 'background,color 1s',
                                        background: bgcolor,
                                        color: 'rgb(255,255,255)',
                                        padding: '10px',
                                        textAlign: 'center',
                                    }}
                                >
                                    <div
                                        style={{
                                            display:'inline-block',
                                            width: '25%',
                                            height: '100%',
                                            verticalAlign: 'top',
                                            borderRight: '1px solid white',
                                            padding: '0 10px',
                                            fontSize: '1vw',
                                        }}
                                        dangerouslySetInnerHTML={{__html:tag}}
                                    ></div>
                                    <div
                                        style={{
                                            display:'inline-block',
                                            width: '75%',
                                            height: '100%',
                                            verticalAlign: 'top',
                                            fontSize: '.8vw',
                                            lineHeight: '1.5vw'
                                        }}
                                    >
                                        <p
                                            style={{
                                                overflow:'hidden',
                                                textOverflow:'ellipsis',
                                                whiteSpace: 'nowrap',
                                            }}
                                        >{item.title}</p>
                                        <p
                                            style={{
                                                overflow:'hidden',
                                                textOverflow:'ellipsis',
                                                whiteSpace: 'nowrap',
                                            }}
                                        >
                                            {
                                                this.theTime(item.startTime,item.endTime)
                                            }
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    );
                })
            }
            </div>
        );
    }
}

// 问答列表
class QuestionList extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            list: [],
            limit: 9,
            current: 1,
            total: 1000
        }
    }
    componentWillMount(){
        this.setState({
            list:[
                {
                    question: '11月12日上午有一个100多人的ROTARIAN计划安排来贵馆参观，不知是否可以安排人工讲解服务？另，我团队预约的话，一定需要提供所有参观团员的个人证件号码等信息么？',
                    answer  : '您好，请联系我馆服务台进行咨询，电话：0512-67575666。谢谢。'
                },
                {
                    question: '11月12日上午有一个100多人的ROTARIAN计划安排来贵馆参观，不知是否可以安排人工讲解服务？另，我团队预约的话，一定需要提供所有参观团员的个人证件号码等信息么？',
                    answer  : '您好，请联系我馆服务台进行咨询，电话：0512-67575666。谢谢。'
                },
                {
                    question: '11月12日上午有一个100多人的ROTARIAN计划安排来贵馆参观，不知是否可以安排人工讲解服务？另，我团队预约的话，一定需要提供所有参观团员的个人证件号码等信息么？',
                    answer  : '您好，请联系我馆服务台进行咨询，电话：0512-67575666。谢谢。'
                },
                {
                    question: '11月12日上午有一个100多人的ROTARIAN计划安排来贵馆参观，不知是否可以安排人工讲解服务？另，我团队预约的话，一定需要提供所有参观团员的个人证件号码等信息么？',
                    answer  : '您好，请联系我馆服务台进行咨询，电话：0512-67575666。谢谢。'
                }
            ]
        })
    }
    componentDidMount(){

    }
    handleClickPage = (page) => {
        this.setState({
            current: page
        })
    }
    render(){
        return(
            <div style={{width:'100%',padding:'1vw 3vw'}}>
            {
                this.state.list.map((item, index)=>{
                    return(
                        <div key={index} style={{marginTop:'0.65vw'}}>
                            <div style={{background:'rgb(177,141,100)',height:'3vw'}}></div>
                            <div
                                style={{
                                    background:'white',
                                    border: '1px solid rgb(177,141,100)',
                                    marginTop:'.2vw',
                                    padding :'0 1vw',
                                    color: 'rgb(85,85,85)'
                                }}
                            >
                                <p
                                    style={{
                                        padding :'3vw 0'
                                    }}
                                >
                                    <span style={{color:'rgb(170,144,100)'}}>观众提问：</span>
                                    {item.question}
                                </p>
                                <hr style={{borderTop:'1px solid rgb(177,141,100)'}} />
                                <p
                                    style={{
                                        padding :'3vw 0'
                                    }}
                                >
                                    <span style={{color:'rgb(170,144,100)'}}>管理员回复：</span>
                                    {item.answer}
                                </p>
                            </div>
                        </div>
                    );
                })
            }
            {
            // <Pager
            //     limit={this.state.limit}
            //     current={this.state.current}
            //     total={this.state.total}
            //     onClick={(page)=>{
            //         this.handleClickPage(page);
            //     }}
            // />
            }
            </div>
        );
    }
}

// 分页
class Pager extends React.Component{
    constructor(props) {
        super(props);
        this.state={}
    }
    render(){
        let page = {
            display:'inline-block',
            cursor:'pointer',
            color:'rgb(85,85,85)',
            margin: '0 .5vw',
            width: '2.5vw',
            height:'2.5vw',
            borderRadius: '1.25vw',
            lineHeight: '2.5vw',
            fontSize:'1.2vw',
            background: 'none',
            transition: 'background 0.5s',
        }
        let currentPage = {
            ...page,
            background: 'rgb(160,35,41)',
            color: 'white'
        }
        return(
            <div style={{textAlign:'center'}}>
                <button style={{
                        ...page,
                        width:'auto'
                    }}
                    onClick={()=>{
                        this.props.onClick(1);
                    }}
                    disabled={this.props.current === 1?true:false}
                >首页</button>
                <button style={{
                        ...page,
                        width:'auto'
                    }}
                    onClick={()=>{
                        this.props.onClick(this.props.current-1<1?1:this.props.current-1);
                    }}
                    disabled={this.props.current === 1?true:false}
                >上一页</button>
                {
                    (()=>{
                        let { current, total, limit, maxShowPages } = this.props;
                        let pages = Math.ceil(total/limit);
                        let numPage = [];
                        if(pages <= maxShowPages){
                            for (let i = 0; i < pages; i++) {
                                numPage.push(i+1);
                            }
                        }else{
                            for (let i = 0; i < pages; i++) {
                                if(Math.abs(i-current) < maxShowPages / 2){
                                    numPage.push(i+1);
                                }
                            }
                        }
                        if(!numPage.includes(1)){
                            numPage.unshift('...');
                        }
                        if(!numPage.includes(pages)){
                            numPage.push('...');
                        }
                        return numPage.map((item, index)=>
                            (<button
                                style={current === item?currentPage:page}
                                onClick={()=>{
                                    if(item!=='...'){
                                        this.props.onClick(item);
                                    }
                                }}
                                disabled={current === item?true:false}
                            >{item}</button>)
                        )
                    })()
                }
                <button style={{
                        ...page,
                        width:'auto'
                    }}
                    onClick={()=>{
                        let { current, total, limit } = this.props;
                        let page = current+1>Math.ceil(total/limit)?Math.ceil(total/limit):current+1
                        this.props.onClick(page);
                    }}
                    disabled={this.props.current === Math.ceil(this.props.total/this.props.limit)?true:false}
                >下一页</button>
                <button style={{
                        ...page,
                        width:'auto'
                    }}
                    onClick={()=>{
                        this.props.onClick(Math.ceil(this.props.total/this.props.limit));
                    }}
                    disabled={this.props.current === Math.ceil(this.props.total/this.props.limit)?true:false}
                >末页</button>
            </div>
        );
    }
}

// 日历
class Calendar extends React.Component{
    constructor(props) {
        super(props);
        let year = new Date().getFullYear();
        let month = new Date().getMonth();
        let days = new Date(year,month+1,0).getDate();
        this.state={
            year,
            month,
            days,
            activitys:[]
        }
    }
    async componentWillMount(){
        let timeList = await getEducationList({time:true});
        this.setState({
            activitys: timeList
        });
    }
    getDays = (days) => {
        let arr = [];
        for (var i = 0; i < days; i++) {
            arr.push(i+1);
        }
        return arr;
    }
    render(){
        return(
            <div className={'animated fadeInRight'}
                style={{
                    background:'url(/static/media/ggjy/bg1.png) no-repeat center / auto 102%',
                    width:'85%',
                    height:'31vw',
                    margin:'0 auto'
                }}>
                <div style={{padding:'4vw 35% 4vw'}}>
                    <p
                        style={{position:'relative', margin:'0 auto',textAlign:'center',color:'white',fontSize:'2vw'}}
                    >
                        {monthArr[this.state.month]}
                        <span
                            className={'calendar-btn'}
                            style={{
                                left:'0'
                            }}
                            onClick={()=>{
                                let {year,month} = this.state;
                                year = month>0?year:year-1;
                                month = month>0?month-1:11;
                                let days = new Date(year,month+1,0).getDate();
                                this.setState({
                                    year,
                                    month,
                                    days
                                })
                            }}
                        >
                            {'<'}
                        </span>
                        <span
                            className={'calendar-btn'}
                            style={{
                                right:'0',
                            }}
                            onClick={()=>{
                                let {year,month} = this.state;
                                year = month<11?year:year+1;
                                month = month<11?month+1:0;
                                let days = new Date(year,month+1,0).getDate();
                                this.setState({
                                    year,
                                    month,
                                    days
                                })
                            }}
                        >
                            {'>'}
                        </span>
                    </p>
                </div>
                <div
                    style={{
                        width:'85%',
                        margin:'0 auto',
                        color: 'white'
                    }}
                >
                    {
                        this.getDays(this.state.days).map((item, index)=>{
                            let isActive = this.state.activitys.find(it=>{
                                let { year,month } = this.state;
                                let timestamp = Date.parse(new Date(`${year}-${month+1}-${item}`));
                                return (timestamp>it.startTime && timestamp<it.endTime);
                            });
                            let week = new Date(this.state.year,this.state.month,item).getDay();
                            return(
                                <div
                                    key={index}
                                    className={`calendar-item ${isActive?'active':''} animated fadeIn`}
                                >
                                    {item}
                                    {
                                        isActive?
                                        <p style={{fontSize:'.6vw',marginTop:'.3vw'}}>
                                            <span className={'a-line'} style={{width:'100%'}}>{weekArr2[week]}</span>
                                            <hr style={{borderTop:'1px solid white',width:'90%',margin:'0 auto'}}/>
                                            活动
                                        </p>
                                        :
                                        <p className={'week'} style={{fontSize:'.6vw',marginTop:'1vw'}}>
                                            {weekArr2[week]}
                                        </p>
                                    }
                                </div>
                            );
                        })
                    }
                </div>
            </div>
        );
    }
}

// 公共教育列表
class EducationList extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            list: [],
            limit: 4,
            current: 1,
            total: 1,
            loading: false
        }
    }
    handleClickPage = (page) => {
        const { limit,current } = this.state;
        this.setState({
            current: page,
        });
        this.fetch({
            limit: limit,
            page: page,
        });
    }
    fetch = async (params = {}) => {
        this.setState({
            loading:true
        });
        const { limit,current,list } = this.state;
        let data = await getEducationList({
            page: params.page || current,
            limit: params.limit || limit,
        });
        this.setState({
            list: list.concat(data.data),
            total: data.count,
            loading: false
        });
    }
    componentWillMount(){
        this.fetch();
    }
    theTime = (startTime, endTime) => {
        let s = new Date(startTime.toString().length===10?startTime*1000:startTime);
        let e = new Date(endTime.toString().length===10?endTime*1000:endTime);
        return `${s.getFullYear()}年${s.getMonth()+1}月${s.getDate()}日 ${weekArr[s.getDay()]} ${s.getHours()}:${s.getMinutes()}—${e.getHours()}:${e.getMinutes()}`;
    }
    render(){
        return(
            <div style={{width:'100%'}}>
            {
                this.state.list.map((item, index)=>{
                    return(
                        <a href={item.href} key={index}>
                            <div className={'animated fadeInUp'} style={{
                                position:'relative',
                                background:`url('${item.src}') no-repeat left center / auto 100%`,
                                width: '100%',
                                paddingTop: '33.94%',
                                display:'inline-block',
                                marginBottom: '4%',
                                marginRight:`${(index+1)%2!==0?'10%':'0'}`
                            }}>
                                <div style={{
                                        position:'absolute',
                                        right:'0',
                                        bottom:'0',
                                        width:'40%',
                                        height:'100%',
                                        transition: 'background,color 1s',
                                        background: 'rgb(164,140,103)',
                                        color: 'rgb(255,255,255)',
                                        padding: '3vw',
                                        textAlign: 'left',
                                        fontSize: '1.3vw',
                                    }}
                                >
                                    <p
                                        style={{
                                            textAlign: 'center',
                                            fontSize: '2vw',
                                        }}
                                    >{item.title}</p>
                                    <p style={{margin:'2vw 0'}}>时间：
                                        {
                                            this.theTime(item.startTime,item.endTime)
                                        }
                                    </p>
                                    <p className={'a-line'} style={{margin:'2vw 0'}}>
                                        地点：{item.addr}
                                    </p>
                                    <p className={'a-line'} style={{margin:'2vw 0'}}>
                                        主讲人：{item.speaker}
                                    </p>
                                </div>
                            </div>
                        </a>
                    );
                })
            }
                <div　style={{textAlign:'center',height:'2vw'}}>
                    {
                        this.state.current<Math.ceil(this.state.total / this.state.limit)?
                        (<button
                            style={{
                                background:'url(/static/media/ggjy/xiala.png) no-repeat center / cover',
                                width: '2vw',
                                height: '2vw',
                                display: this.state.loading?'none':'inline-block'
                            }}
                            onClick={()=>{this.handleClickPage(this.state.current+1)}}
                        />):(
                            <p className={'animated fadeInUp'}　style={{color:'rgb(85,85,85)'}}>没有更多数据了</p>
                        )
                    }
                </div>
            </div>
        );
    }
}

// 新闻列表
class NewsList extends React.Component{
    constructor(props){
        super(props);
        this.state={
            list: [],
            limit: 8,
            current: 1,
            total: 1,
            category: this.props.category,
            title: this.props.title || undefined
        }
    }
    handleClickPage = (page) => {
        const { limit,current,category } = this.state;
        this.setState({
            current: page,
        });
        this.fetch({
            limit: limit,
            page: page,
            category: category
        });
    }
    fetch = async (params = {}) => {
        const { limit,current,category } = this.state;
        let data = await getNewsList({
            page: params.page || current,
            limit: params.limit || limit,
            category: this.state.category || undefined,
            title: this.state.title || undefined
        });
        this.setState({
            list: data.data,
            total: data.count
        });
    }
    componentWillMount(){
        this.fetch();
    }
    theTime = (time) => {
        let t = new Date(time.toString().length===10?time*1000:time);
        return `${t.getMonth()+1}月${t.getDate()}日`;
    }
    render(){
        let currentTime = '';
        return(
            <div style={{padding:'0 10vw'}}>
                <div>
                    {
                        this.state.list.map((item, index)=>{
                            let time = this.theTime(item.time);
                            if(time === currentTime){
                                time = '';
                            }else{
                                currentTime = time;
                            }
                            return(
                                <div style={{fontSize:'1.3vw',color:'rgb(85,85,85)'}}>
                                    <div
                                        style={{
                                            display:'inline-block',
                                            width:'30%',
                                            height:'4vw',
                                            verticalAlign:'top',
                                            lineHeight:'4vw'
                                        }}>
                                            {time}
                                        </div>
                                    <div className={'a-line'}
                                        style={{
                                            display:'inline-block',
                                            width:'70%',
                                            height:'4vw',
                                            verticalAlign:'top',
                                            lineHeight:'4vw',
                                            borderBottom: '1px solid rgb(187,187,187)'
                                        }}>
                                        <a href={item.href}>
                                            {item.title}
                                        </a>
                                    </div>
                                </div>
                            );
                        })
                    }
                </div>
                <div className={'clear'}></div>
                <div style={{position:'absolute', bottom:'4vw', width:'calc(100% - 20vw)'}}>
                    <Pager
                        limit={this.state.limit}
                        current={this.state.current}
                        total={this.state.total}
                        maxShowPages={6}
                        onClick={(page)=>{
                            this.handleClickPage(page);
                        }}
                    />
                </div>
            </div>
        );
    }
}

// 大事件
class EventsList extends React.Component{
    constructor(props) {
        super(props);
        this.state={
            list: [],
            count: 0,
            leftCount: 0,
            showCount: 7
        }
    }
    async componentWillMount(){
        let list = await getEventsList();
        this.setState({
            list,
            count: list.length
        })
    }
    render(){
        return(
            <div style={{
                position: 'relative',
                margin: '3vw auto',
                width: '64%'
            }}>
                <div style={{
                    position:'relative',
                    height:'6.25vw',
                    overflow:'hidden'
                }}>
                {
                    this.state.list.map((item, index)=>{
                        return(
                            <a key={index} href={`/profile/events/${item._id.$oid}`}>
                                <span
                                    style={{
                                        position:'absolute',
                                        width: '6.25vw',
                                        height: '6.25vw',
                                        margin: '0 1.6vw',
                                        background: 'rgb(160,35,41)',
                                        display: 'inline-block',
                                        borderRadius: '50%',
                                        lineHeight: '6.25vw',
                                        color: 'white',
                                        fontSize: '2vw',
                                        overflow: 'hidden',
                                        textAlign: 'center',
                                        transition: 'transform,opacity 1s',
                                        transform: `translateX(${7.85*(index-this.state.leftCount)}vw)`,
                                    }}
                                >
                                    <span
                                        style={{display:'inline-block'}}
                                        className={'animated'}
                                        onMouseOver={e=>{
                                            let ele = e.target;
                                            ele.classList.add('rubberBand');
                                            setTimeout(()=>{
                                                ele.classList.remove('rubberBand')
                                            },1000)
                                        }}
                                    >{item.year}</span>
                                </span>
                            </a>
                        );
                    })
                }
                </div>
                <button
                    style={{
                        position: 'absolute',
                        top: '1.12vw',
                        left: '-3vw',
                        width: '2vw',
                        height: '4vw',
                        cursor: 'pointer',
                        background: 'url(/static/media/2/6.jpg) no-repeat center / auto 100%',
                    }}
                    onClick={()=>{
                        if(this.state.leftCount>0){
                            this.setState({
                                leftCount: this.state.leftCount-1
                            })
                        }
                    }}
                />
                <button
                    style={{
                        position: 'absolute',
                        top: '1.12vw',
                        right: '-3vw',
                        width: '2vw',
                        height: '4vw',
                        cursor: 'pointer',
                        background: 'url(/static/media/2/5.jpg) no-repeat center / auto 100%',
                    }}
                    onClick={()=>{
                        if(this.state.count - this.state.showCount > this.state.leftCount){
                            this.setState({
                                leftCount: this.state.leftCount+1
                            })
                        }
                    }}
                />
            </div>
        );
    }
}