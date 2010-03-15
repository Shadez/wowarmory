<?xml version="1.0" encoding="UTF-8"?><page globalSearch="1" lang="{$ArmoryConfig.locale}" requestUrl="character-model.xml">
  <tabInfo tab="character" tabGroup="character" tabUrl="r={$urlName}"/>
  <character>
    <models>
      <model baseY="0.97" facedY="1.6" hideCape="{$character_model_data.hide_cloak}" hideHelm="{$character_model_data.hide_helm}" id="0" modelFile="character/{$character_model_data.race}/{$character_model_data.gender}/{$character_model_data.race}{$character_model_data.gender}.m2" name="base" scale="1.7" skinFile="character/{$character_model_data.race}/{$character_model_data.gender}/{$character_model_data.race}{$character_model_data.gender}00.skin">
        <components>
          {*
          Need more info about these components...
          Known:
              hair_style - generic
              leggs_type - 1301 (male) / 1302 (female)
              eyes_glow - 1702 (dk?)
              dk_eyes - 1703
              tabard - 1202 (?)
              cape - 1502
          *}
          <component n="100"/>
          <component n="200"/>
          <component n="801"/>
          <component n="401"/>
          {if $character_model_data.class == 6}
          <component n="1703"/>
          {/if}
          <component n="601"/>
          <component n="{$character_model_data.hair_style}"/>
          <component n="130{if $character_model_data.gender_1 == 'm'}1{else}2{/if}"/>
          <component n="901"/>
          <component n="302"/>
          <component n="1600"/>
          <component n="1201"/>
          <component n="702"/>
          <component n="1001"/>
          <component n="1401"/>
          <component n="1501"/>
          <component n="0"/>
          <component n="101"/>
          <component n="301"/>
          <component n="1101"/>
          <component n="502"/>
          <component n="1502"/>
        </components>
        <textures>
          <texture file="character/{$character_model_data.race}/{$character_model_data.gender}/{$character_model_data.race}{$character_model_data.gender}skin00_{$character_model_data.skin_style}.png" id="1">
            {if isset($model_data.shirt_au.file) && $model_data.shirt_au.file != 'item/texturecomponents/armuppertexture/_u.png' && $model_data.shirt_au.file != ''}
            <subTexture file="{$model_data.shirt_au.file}" fileBackup="{$model_data.shirt_au.fileBackup}" h="0.25" w="0.5" x="0.0" y="0.0"/>
            {/if}
            {if isset($model_data.chest_au.file) && $model_data.chest_au.file != 'item/texturecomponents/armuppertexture/_u.png' && $model_data.chest_au.file != ''}
            <subTexture file="{$model_data.chest_au.file}" fileBackup="{$model_data.chest_au.fileBackup}" h="0.25" w="0.5" x="0.0" y="0.0"/>
            {/if}
            {if isset($model_data.shirt_al.file) && $model_data.shirt_al.file != 'item/texturecomponents/armlowertexture/_u.png' && $model_data.shirt_al.file != ''}
            <subTexture file="{$model_data.shirt_al.file}" fileBackup="{$model_data.shirt_al.file}" h="0.25" w="0.5" x="0.0" y="0.25"/>
            {/if}
            {if isset($model_data.bracers_al.file) && $model_data.bracers_al.file != 'item/texturecomponents/armlowertexture/_u.png' && $model_data.bracers_al.file != ''}
            <subTexture file="{$model_data.bracers_al.file}" fileBackup="{$model_data.bracers_al.fileBackup}" h="0.25" w="0.5" x="0.0" y="0.25"/>
            {/if}
            {if isset($model_data.gloves_al.file) && $model_data.gloves_al.file != 'item/texturecomponents/armlowertexture/_u.png' && $model_data.gloves_al.file != ''}
            <subTexture file="{$model_data.gloves_al.file}" fileBackup="{$model_data.gloves_al.fileBackup}" h="0.25" w="0.5" x="0.0" y="0.25"/>
            {/if}
            {if isset($model_data.hand.file) && $model_data.hand.file != 'item/texturecomponents/handtexture/_u.png' && $model_data.hand.file != ''}
            <subTexture file="{$model_data.hand.file}" fileBackup="{$model_data.hand.fileBackup}" h="0.125" w="0.5" x="0.0" y="0.5"/>
            {/if}
            <subTexture file="character/{$character_model_data.race}/{$character_model_data.gender}/{$character_model_data.race}{$character_model_data.gender}faceupper00_00.png" h="0.125" w="0.5" x="0.0" y="0.625"/>
            <subTexture file="character/{$character_model_data.race}/scalpupperhair00_02.png" h="0.125" w="0.5" x="0.0" y="0.625"/>
            <subTexture file="character/{$character_model_data.race}/{$character_model_data.gender}/{$character_model_data.race}{$character_model_data.gender}facelower00_00.png" h="0.25" w="0.5" x="0.0" y="0.75"/>
            <subTexture file="character/{$character_model_data.race}/scalplowerhair00_02.png" h="0.25" w="0.5" x="0.0" y="0.75"/>
            {if isset($model_data.shirt_tu.file) && $model_data.shirt_tu.file != 'item/texturecomponents/torsouppertexture/_u.png' && $model_data.shirt_tu.file != ''}
            <subTexture file="{$model_data.shirt_tu.file}" fileBackup="{$model_data.shirt_tu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.0"/>
            {/if}
            {if isset($model_data.chest_tu.file) && $model_data.chest_tu.file != 'item/texturecomponents/torsouppertexture/_u.png' && $model_data.chest_tu.file != ''}
            <subTexture file="{$model_data.chest_tu.file}" fileBackup="{$model_data.chest_tu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.0"/>
            {/if}
            {if isset($model_data.tabard_tu.file) && $model_data.tabard_tu.file != 'item/texturecomponents/torsouppertexture/_u.png' && $model_data.tabard_tu.file != ''}
            <subTexture file="{$model_data.tabard_tu.file}" fileBackup="{$model_data.tabard_tu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.0"/>
            {/if}
            {if isset($model_data.shirt_tl.file) && $model_data.shirt_tl.file != 'item/texturecomponents/torsolowertexture/_u.png' && $model_data.shirt_tl.file != ''}
            <subTexture file="{$model_data.shirt_tl.file}" fileBackup="{$model_data.shirt_tl.fileBackup}" h="0.125" w="0.5" x="0.5" y="0.25"/>
            {/if}
            {if isset($model_data.chest_tl.file) && $model_data.chest_tl.file != 'item/texturecomponents/torsolowertexture/_u.png' && $model_data.chest_tl.file != ''}
            <subTexture file="{$model_data.chest_tl.file}" fileBackup="{$model_data.chest_tl.fileBackup}" h="0.125" w="0.5" x="0.5" y="0.25"/>
            {/if}
            {if isset($model_data.tabard_tl.file) && $model_data.tabard_tl.file != 'item/texturecomponents/torsolowertexture/_u.png' && $model_data.tabard_tl.file != ''}
            <subTexture file="{$model_data.tabard_tl.file}" fileBackup="{$model_data.tabard_tl.fileBackup}" h="0.125" w="0.5" x="0.5" y="0.25"/>
            {/if}
            {if isset($model_data.belt_tl.file) && $model_data.belt_tl.file != 'item/texturecomponents/torsolowertexture/_u.png' && $model_data.belt_tl.file != ''}
            <subTexture file="{$model_data.belt_tl.file}" fileBackup="{$model_data.belt_tl.fileBackup}" h="0.125" w="0.5" x="0.5" y="0.25"/>
            {/if}
            {if isset($model_data.leg_lu.file) && $model_data.leg_lu.file != 'item/texturecomponents/leguppertexture/_u.png' && $model_data.leg_lu.file != ''}
            <subTexture file="{$model_data.leg_lu.file}" fileBackup="{$model_data.leg_lu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.375"/>
            {/if}
            {if isset($model_data.chest_lu.file) && $model_data.chest_lu.file != 'item/texturecomponents/leguppertexture/_u.png' && $model_data.chest_lu.file != ''}
            <subTexture file="{$model_data.chest_lu.file}" fileBackup="{$model_data.chest_lu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.375"/>
            {/if}
            {if isset($model_data.belt_lu.file) && $model_data.belt_lu.file != 'item/texturecomponents/leguppertexture/_u.png' && $model_data.belt_lu.file != ''}
            <subTexture file="{$model_data.belt_lu.file}" fileBackup="{$model_data.belt_lu.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.375"/>
            {/if}
            {if isset($model_data.leg_ll.file) && $model_data.leg_ll.file != 'item/texturecomponents/leglowertexture/_u.png' && $model_data.leg_ll.file != ''}
            <subTexture file="{$model_data.leg_ll.file}" fileBackup="{$model_data.leg_ll.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.625"/>
            {/if}
            {if isset($model_data.leg_ll.file) && $model_data.boot_ll.file != 'item/texturecomponents/leglowertexture/_u.png' && $model_data.boot_ll.file != ''}
            <subTexture file="{$model_data.boot_ll.file}" fileBackup="{$model_data.boot_ll.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.625"/>
            {/if}
            {if isset($model_data.chest_ll.file) && $model_data.chest_ll.file != 'item/texturecomponents/leglowertexture/_u.png' && $model_data.chest_ll.file != ''}
            <subTexture file="{$model_data.chest_ll.file}" fileBackup="{$model_data.chest_ll.fileBackup}" h="0.25" w="0.5" x="0.5" y="0.625"/>
            {/if}
            {if isset($model_data.boot_fo.file) && $model_data.boot_fo.file != 'item/texturecomponents/foottexture/_u.png' && $model_data.boot_fo.file != ''}
            <subTexture file="{$model_data.boot_fo.file}" fileBackup="{$model_data.boot_fo.fileBackup}" h="0.125" w="0.5" x="0.5" y="0.875"/>
            {/if}
          </texture>
          <texture file="character/{$character_model_data.race}/hair00_{$character_model_data.hair_color}.png" id="6"/>
          {if $character_model_data.hide_cloak == 0 && $model_data.back_texture.file}
          <texture file="{$model_data.back_texture.file}" id="2"/>
          {/if}
        </textures>
        <attachments>
          {if $model_data.helm_texture.modelFile && $character_model_data.hide_helm == 0}
          <attachment linkPoint="11" modelFile="{$model_data.helm_texture.modelFile}" skinFile="{$model_data.helm_texture.skinFile}" texture="{$model_data.helm_texture.texture}" type="none"/>
          {/if}
          {if $model_data.left_shoulder_texture.modelFile && $model_data.right_shoulder_texture.modelFile}
          <attachment linkPoint="6" modelFile="{$model_data.left_shoulder_texture.modelFile}" skinFile="{$model_data.left_shoulder_texture.skinFile}" texture="{$model_data.left_shoulder_texture.texture}" type="none"/>
          <attachment linkPoint="5" modelFile="{$model_data.right_shoulder_texture.modelFile}" skinFile="{$model_data.right_shoulder_texture.skinFile}" texture="{$model_data.right_shoulder_texture.texture}" type="none"/>
          {/if}
          {if $model_data.main_hand_texture.modelFile}
          <attachment linkPoint="1" modelFile="{$model_data.main_hand_texture.modelFile}" skinFile="{$model_data.main_hand_texture.skinFile}" texture="{$model_data.main_hand_texture.texture}" type="melee"/>
          {/if}
          {if $model_data.off_hand_texture.modelFile}
          <attachment linkPoint="{if $model_data.use_shield == true}0{else}1{/if}" modelFile="{$model_data.off_hand_texture.modelFile}" skinFile="{$model_data.off_hand_texture.skinFile}" texture="{$model_data.off_hand_texture.texture}" type="{if $model_data.use_shield == true}melee{else}ranged{/if}"/>
          {/if}
        </attachments>
        <animations>
          <animation id="0" key="stand" weapons="melee"/>
          <animation id="69" key="dance" weapons="no"/>
          <animation id="70" key="laugh" weapons="no"/>
          <animation id="82" key="flex" weapons="no"/>
          <animation id="78" key="chicken" weapons="no"/>
          <animation id="120" key="crouch" weapons="no"/>
          <animation id="60" key="talk" weapons="no"/>
          <animation id="66" key="bow" weapons="no"/>
          <animation id="67" key="wave" weapons="no"/>
          <animation id="73" key="rude" weapons="no"/>
          <animation id="76" key="kiss" weapons="no"/>
          <animation id="77" key="cry" weapons="no"/>
          <animation id="84" key="point" weapons="no"/>
          <animation id="113" key="salute" weapons="no"/>
          <animation id="185" key="yes" weapons="no"/>
          <animation id="186" key="no" weapons="no"/>
          <animation id="195" key="train" weapons="no"/>
          <animation id="51" key="readyspelldirected" weapons="no"/>
          <animation id="52" key="readyspellomni" weapons="no"/>
          <animation id="53" key="castdirected" weapons="no"/>
          <animation id="54" key="castomni" weapons="no"/>
          <animation id="108" key="readythrown" weapons="ranged"/>
          <animation id="107" key="attackthrown" weapons="ranged"/>
        </animations>
        <backgrounds>
          <background file="bgs/full/bloodelf" key="bloodelf" scale="3.25" x="0" y="140"/>
          <background file="bgs/full/argenttournament" key="argenttournament" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/dalaran" key="dalaran" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/shattrath" key="shattrath" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/shattrath2" key="shattrath2" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/wintergrasp" key="wintergrasp" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/alteracvalley_horde" key="alteracvalley_horde" scale="2.8" x="0" y="155"/>
          <background file="bgs/full/alteracvalley_alliance" key="alteracvalley_alliance" scale="2.8" x="0" y="155"/>
        </backgrounds>
      </model>
    </models>
  </character>
</page>
