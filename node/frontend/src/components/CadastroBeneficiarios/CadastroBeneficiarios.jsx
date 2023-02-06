import { 
  Heading, 
  VStack, 
  Button, 
  useDisclosure, 
  Modal, 
  ModalOverlay, 
  ModalContent, 
  ModalHeader, 
  ModalCloseButton, 
  ModalBody, 
  Text, 
  Tag, 
  useToast, 
  Box
} from "@chakra-ui/react";
import { Formik, Field, FieldArray } from "formik";
import * as Yup from "yup";
import {
  FormControl,
  FormErrorMessage,
  FormLabel,
} from "@chakra-ui/form-control";
import { Input } from "@chakra-ui/input";
import { api } from '../../services/api';
import { useMutation } from 'react-query'
import { useEffect, useState } from "react";

export function CadastroBeneficiarios() {
  const toast = useToast()
  const { isOpen, onOpen, onClose } = useDisclosure()
  const [proposta, setProposta] = useState({})

  useEffect(() => {
    if (proposta.planoEscolhido) {
      onOpen()
    }
  }, [proposta])

  async function cadastrarBeneficiarios(data) {
    return await api().post('/proposta', data)
      .then((res) => {return res.data})
      .catch((res) => {return res.data})
  }

  const cadastrarBeneficiariosMutation = useMutation(
    (data) => cadastrarBeneficiarios(data),
    {
      onSuccess: (res) => {
        if (res.message) {
          toast({
            title: 'Erro ao criar proposta',
            description: res.message,
            status: 'error',
            duration: 9000,
            isClosable: true,
          })
        } else {
          setProposta(res.data)
        }

      },
      onError: (res) => {
        alert(res)
      }
    })

  const moneyFormatter = new Intl.NumberFormat('br-BR', { style: 'currency', currency: 'BRL' });

  return (
    <Box w="100vw" h="100vh" p="2rem" display="flex" justifyContent="center">
      <Formik
        initialValues={{ 
          planoEscolhido: '', 
          quantidadeBeneficiarios: '',
          beneficiarios: [
            {
              nome: '',
              idade: '',
            }
          ],
        }}
        validationSchema={Yup.object({
          planoEscolhido: Yup.string()
            .required("Plano e obrigatorio"),
          quantidadeBeneficiarios: Yup.number()
            .required("Quantidade benefiaciarios e obrigatorio")
            .positive("Ultilize somente numeros positivos")
            .integer("Ultilize somente numeros inteiros"),
        })}
        onSubmit={(values, actions) => {
          cadastrarBeneficiariosMutation.mutate(values)
          // actions.resetForm();
        }}
      >
        {formik => (
          <VStack
            as="form"
            p="1rem"
            onSubmit={formik.handleSubmit}
          >
            <Heading>Plano Planium</Heading>

            <FormControl isInvalid={formik.errors.planoEscolhido && formik.touched.planoEscolhido}>
              <FormLabel>Plano</FormLabel>
              <Field as={Input}
              name="planoEscolhido"
              placeholder="ex: Bitix Customer Plano 1" />
              <FormErrorMessage>{formik.errors.planoEscolhido}</FormErrorMessage>
            </FormControl>

            <FormControl isInvalid={formik.errors.quantidadeBeneficiarios && formik.touched.quantidadeBeneficiarios}>
              <FormLabel> Quantidade Beneficiario</FormLabel>
              <Field as={Input}
              name="quantidadeBeneficiarios"
              placeholder="ex: 1"
              type="number" />
              <FormErrorMessage>{formik.errors.quantidadeBeneficiarios}</FormErrorMessage>
            </FormControl>

            <FieldArray
              name="beneficiarios"
              render={arrayHelpers => (
                <div>
                  {formik.values.beneficiarios && formik.values.beneficiarios.length > 0 ? (
                    formik.values.beneficiarios.map((Beneficiario, index) => (
                      <div key={index}>
                          <FormLabel>Beneficiario</FormLabel>
                          <Field as={Input}
                          name={`beneficiarios[${index}].nome`}
                          placeholder="Nome ex: Joao" />
                          <Field as={Input}
                          name={`beneficiarios[${index}].idade`}
                          placeholder="Idade ex: 17" />
                          <Button
                          type="button"
                          onClick={() => arrayHelpers.remove(index)}
                        >
                          -
                        </Button>
                        <Button
                          type="button"
                          onClick={() => arrayHelpers.insert(index, '')}
                        >
                          +
                        </Button>
                      </div>
                    ))
                  ) : (
                    <Button type="button" onClick={() => arrayHelpers.push('')}>
                      Adicionar Beneficiario
                    </Button>
                  )}
                </div>
              )}
            />
            
            <Button type="submit" variant="outline" colorScheme="teal">
              Enviar Proposta
            </Button>
          </VStack>
        )}
      </Formik>

      <Modal isOpen={isOpen} onClose={onClose}>
        <ModalOverlay />
        <ModalContent>
          <ModalHeader mt="1rem" >Proposta</ModalHeader>
          <ModalCloseButton />
          <ModalBody>
            <Text>Plano: {proposta.planoEscolhido}</Text>
            <Text>Quantidade de beneficiários: {proposta.quantidadeBeneficiarios}</Text>
            <Text>Beneficiários:</Text>
            <VStack gap={1} alignItems="flex-start">
              {proposta.beneficiarios && proposta.beneficiarios.map((beneficiario) => {
                return <Tag colorScheme="teal"> 
                  Nome: {beneficiario.nome} 
                  | Idade: {beneficiario.idade} 
                  | Valor: {moneyFormatter.format(beneficiario.preco)}
                </Tag>
              })}
            </VStack>
            <Text mt={3}>Valor total da proposta: {moneyFormatter.format(proposta.valorToral)}</Text>
          </ModalBody>
        </ModalContent>
      </Modal>              
    </Box>
  )
}