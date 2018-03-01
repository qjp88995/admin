function webglAvailable() {
    try {
        var canvas = document.createElement( 'canvas' );
        // !!() 两次取反，表示将括号内强制转为bool值，（’‘，[], {} 都判断为true）
        return !!( window.WebGLRenderingContext && (
            canvas.getContext( 'webgl' ) ||
            canvas.getContext( 'experimental-webgl' ) )
        );
    } catch ( e ) {
        return false;
    }
}

var ThreeModel = function (options /* {elm: 'threeJS', model: 'model.drc', 'model_ltintensity': 1.4} */) {
    this.render = this.render.bind(this)
    this.onWindowResize = this.onWindowResize.bind(this)

    var self = this
    var options = this.options = options || {}
    this.options.vr_enabled = options.vr_enabled || false

    var elm = this.rootElm = document.getElementById(options.elm || options.elmId)
    var containerWidth = elm.clientWidth, containerHeight = elm.clientHeight
    var scene = this.scene = new THREE.Scene
    if (!options.scene_transparent)
        scene.background = new THREE.Color(this.background || 0x333333)

    var camera = this.camera = new THREE.PerspectiveCamera(45, containerWidth / containerHeight, 0.1, 1E4)
    camera.position.set(.0, .7, .7)
    camera.lookAt(scene.position)
    scene.add(camera)


    var renderer
    if ( webglAvailable() ) {
        renderer = new THREE.WebGLRenderer({
            antialias: !0,
            alpha: options.scene_transparent ? true : false
        })
    } else {
        renderer = new THREE.CanvasRenderer()
    }
    this.renderer = renderer

    renderer.setSize(containerWidth, containerHeight)
    renderer.setPixelRatio(window.devicePixelRatio)
    elm.appendChild(renderer.domElement)
    window.addEventListener('resize', this.onWindowResize, false)
    window.addEventListener("orientationchange", this.onWindowResize, false);

    // 添加半球光源
    scene.add(new THREE.HemisphereLight(0xbbbbbb, 0xbbbbbb, options.light_intensity || 2))
    //
    this.enterNormalMode()

    //
    if (this.options.vr_enabled) {
        var effect = new THREE.VREffect(renderer)
        effect.setSize(window.innerWidth, window.innerHeight)
        //
        var params = {
            hideButton: false, // Default: false.
            isUndistorted: false // Default: false.
        }
        var manager = this.manager = new WebVRManager(renderer, effect, params)
        manager.on('modechange', function (mode) {
            if (mode === WebVRManager.Modes.VR) {
                self.enterVRMode()
            } else {
                self.enterNormalMode()
            }
        })
    }
    this.listeners = {}
}

ThreeModel.prototype.enterVRMode = function () {
    // 切换到VR控制器
    if (this.orbitCtl) {
        this.orbitCtl.dispose()
        this.orbitCtl = null
    }
    // 相机位置将被VRControls锁定在在0的位置，因此把模型往前移动一点
    if (this.obj3d) {
        this.obj3d.position.set(.0, .0, -0.7)
    }
    //
    var vrCtl = this.vrCtl = new THREE.VRControls(this.camera)
    vrCtl.standing = true
}

ThreeModel.prototype.enterNormalMode = function () {
    if (this.vrCtl) {
        this.vrCtl.dispose()
        this.vrCtl = null
    }
    // 重置相机位置
    this.camera.position.set(.0, .7, .7)
    if (this.obj3d && this.modelCenter) {
        this.obj3d.position.copy(this.modelCenter)
    }
    //
    var orbitCtl = this.orbitCtl = new THREE.OrbitControls(this.camera, this.rootElm)
    orbitCtl.autoRotate = this.options.auto_rotate || false
}

ThreeModel.prototype.loadModel = function () {
    var dracoLoader = new THREE.DRACOLoader()
    dracoLoader.setCrossOrigin(true)
    dracoLoader.setPath(this.options.path)
    var self = this
    dracoLoader.load(this.options.model, function (blob) {
        self.onGeometryLoaded(blob)
        self.emit('loaded')
    })
}

ThreeModel.prototype.onGeometryLoaded = function (bufferGeometry) {
    bufferGeometry.computeBoundingBox()
    var self = this
    // 装载材质
    var mtlLoader = new THREE.MTLLoader()
    mtlLoader.setPath(this.options.path)
    mtlLoader.setCrossOrigin(true)
    mtlLoader.load(this.options.mtl, function (materials) {
        materials.preload()
        var geometry

        if (bufferGeometry.index == null) {
            geometry = new THREE.Points(bufferGeometry, materials)
        } else {
            bufferGeometry.computeVertexNormals()
            geometry = new THREE.Mesh(bufferGeometry, materials.materials[self.options.material_name || 'image_material'])
        }
        geometry.castShadow = true
        geometry.receiveShadow = true

        // 缩放到单位为1，并居中显示
        bufferGeometry.computeBoundingBox()
        const sizeX = bufferGeometry.boundingBox.max.x - bufferGeometry.boundingBox.min.x
        const sizeY = bufferGeometry.boundingBox.max.y - bufferGeometry.boundingBox.min.y
        const sizeZ = bufferGeometry.boundingBox.max.z - bufferGeometry.boundingBox.min.z
        const diagonalSize = Math.sqrt(sizeX * sizeX + sizeY * sizeY + sizeZ * sizeZ)
        const scale = 1.0 / diagonalSize
        const midX = (bufferGeometry.boundingBox.min.x + bufferGeometry.boundingBox.max.x) / 2
        const midY = (bufferGeometry.boundingBox.min.y + bufferGeometry.boundingBox.max.y) / 2
        const midZ = (bufferGeometry.boundingBox.min.z + bufferGeometry.boundingBox.max.z) / 2

        geometry.scale.multiplyScalar(scale)
        self.modelCenter = new THREE.Vector3(-midX * scale, -midY * scale, -midZ * scale)
        geometry.position.copy(self.modelCenter)

        // 居中显示
        // var threeBox = new THREE.Box3
        // threeBox.union(bufferGeometry.boundingBox)
        // geometry.position.copy(threeBox.getCenter()).negate()
        //
        // // 相机放置在距离物体两倍大小的地方，这样看起来整体比较合适
        // var maxWidth = Math.max(threeBox.max.x - threeBox.min.x, threeBox.max.y - threeBox.min.y, threeBox.max.z - threeBox.min.z) / 2,
        //     doubleWidth = 2 * maxWidth
        // self.camera.position.set(doubleWidth, doubleWidth, doubleWidth)
        // self.orbitCtl.saveState()

        geometry.name = '_model_'
        self.obj3d = geometry
        self.scene.add(geometry)
    })
}

ThreeModel.prototype.onWindowResize = function () {
    this.camera.aspect = window.innerWidth / window.innerHeight
    this.camera.updateProjectionMatrix()
    this.renderer.setSize(window.innerWidth, window.innerHeight)
    if (this.options.vr_enabled) {
        this.manager.render(this.scene, this.camera)
    } else {
        this.renderer.render(this.scene, this.camera)
    }
}

ThreeModel.prototype.render = function (timestamp) {
    this.lastRender = this.lastRender || 0
    if (this.vrCtl && this.obj3d) {
        // vr模式下，3d对象自动旋转
        var delta = Math.min(timestamp - this.lastRender, 500) / 2
        this.lastRender = timestamp
        this.obj3d.rotation.y += delta * 0.0006
    }

    this.orbitCtl && this.orbitCtl.update()
    this.vrCtl && this.vrCtl.update()

    if (this.options.vr_enabled) {
        this.manager.render(this.scene, this.camera, timestamp)
    } else {
        this.renderer.render(this.scene, this.camera)
    }
    requestAnimationFrame(this.render)
}

ThreeModel.prototype.start = function () {
    this.loadModel()
    this.render()
}

ThreeModel.prototype.emit = function (event) {
    var listeners = this.listeners[event] || []
    listeners.forEach(function (l) {
        l && l()
    })
}

ThreeModel.prototype.on = function (event, cb) {
    var listeners = this.listeners[event]
    if (!listeners) {
        listeners = this.listeners[event] = []
    }
    if (listeners.indexOf(cb) < 0) {
        listeners.add(cb)
    }
}